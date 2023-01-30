<?php
namespace Lib;

class Url
{
    protected $pageIndex = self::PAGE_INDEX;
    protected $module;
    protected $action;
    protected $arguments = [];
    
    const PAGE_INDEX = 'index.php';
    const DENOM_MODULE = 'm';
    const DENOM_ACTION = 'a';
    const DENOM_ARG = 'arg';
    
    public function __construct()
    {
        $url = $this->extract();
        $this->hydrate($url);
    }
    
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $denom => $valeur)
        {
            switch ($denom)
            {
                case self::DENOM_MODULE:
                    $this->setModule($valeur);
                break;
                    
                case self::DENOM_ACTION:
                    $this->setAction($valeur);
                break;
                    
                case self::DENOM_ARG:
                    $this->setArguments($valeur);
                break;
            }
        }
    }
    
    public function getPageIndex()  {   return $this->pageIndex;    }
    
    public function getUrl($url = null) {
        return $this->url;
    }
    
    public function getModule($url = null)
    {
        if (isset($url))
        {
            $url = $this->extract($url);
            return $url[self::DENOM_MODULE];
        }
        
        return $this->module;
    }
    
    public function getAction($url = null)
    {
        if (isset($url))
        {
            $url = $this->extract($url);
            return $url[self::DENOM_ACTION];
        }
        
        return $this->action;
    }
    
    public function getArguments($url = null)
    {
        if (isset($url))
        {
            $url = $this->extract($url);
            return $url[self::DENOM_ARG];
        }
        
        return $this->arguments;
    }
    
    public function setPageIndex($pageIndex)
    {
        if (is_string($pageIndex) AND preg_match('#[a-z]\.\[html|php]#i', $pageIndex))
        {
            $this->pageIndex = $pageIndex;
        }
    }
    
    public function setModule($module)
    {
        if (is_string($module))
        {
            $this->module = $module;
        }
    }
    
    public function setAction($action)
    {
        if (is_string($action))
        {
            $this->action = $action;
        }
    }
    
    public function setArguments(array $arguments)
    {
        if (!empty($arguments))
        {
            $this->arguments = $arguments;
        }
    }
    
    public function fetch($module, $action = null, array $arguments = null)
    {
        $url = self::PAGE_INDEX.'?'.$module;
        $url .= ($action !== null && !empty($action)) ? ':'.$action : '';
        
        if (isset($arguments))
        {
            $clesArguments = array_keys($arguments);
            $lastKey = array_pop($clesArguments);
            
            $url .= '[';
                foreach ($arguments as $argument => $valeur)
                {
                    if (is_int($argument)) // Si la clé "argument" est un chiffre, c'est qu'on veut attribuer un argument sans valeur
                    {
                        $url .= $valeur;
                    }
                    else // Sinon, c'est qu'on veut avoir un argument sous la forme "arg=valeur";
                    {
                        $url .= $argument;
                        $url .= '='.$valeur;
                    }
                    
                    $url .= ($argument !== $lastKey) ? ';' : '';
                }
            $url .= ']';
        }
        
        return $url;
    }
    
    public function extract($url = null)
    {
        if(!isset($url))
        {
            $url = $_SERVER['REQUEST_URI'];
        }
        
        $url = preg_split("#\?{1}#", $url);
            unset($url[0]);

        $url = implode('', $url); // Pour transformer le array en chaîne de caractères

            // Récupération des noms des modules, action et arguments s'il y en a
        $module = preg_replace('#([a-z]+):?(.*)#i', '$1', $url);

        
        if (preg_match('#('.$module.'):([a-z]+)\[(.+)\]#i', $url)) // Dans le cas où il y a des arguments renseignés
        {
            $action = preg_replace('#('.$module.'):([\w]+)\[(.+)\]#i', '$2', $url);
            $arguments = preg_replace('#('.$module.'):('.$action.')\[(.+)\]#i', '$3', $url);
    
            $arguments = preg_split('#;#', $arguments, NULL, PREG_SPLIT_DELIM_CAPTURE);

            foreach ($arguments as $cle => $argument)
            {
                $cleArg = preg_replace('#([\w]+)=([\w]+)#i', '$1', $argument);
                $valeur = '';

                if (preg_match('#[\w]+=(.+)#i', $argument))
                {
                   $valeur = preg_replace('#([\w]+)=([\w]+)#i', '$2', $argument); 
                }

                $arguments[$cleArg] = $valeur;
                    unset($valeur);
                    unset($arguments[$cle]);
            }
        }
        else // Dans le cas où il n'y a pas d'arguments renseignés
        {
            $action = preg_replace('#('.$module.'):?([\w]*)(.*)#i', '$2', $url);
            $arguments = [];
        }
        
        $url = [self::DENOM_MODULE => $module,
                self::DENOM_ACTION => $action,
                self::DENOM_ARG => $arguments];

        return $url;
    }
}