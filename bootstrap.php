<?php
require_once __DIR__."/router.php";


if(isset($_SERVER["REQUEST_URI"])){
    $isUrlFound = false;
    $uri = $_SERVER["REQUEST_URI"];
    foreach ($routers as $router){
        $routerSlashed = str_replace("/", "\/", $router["url"]);
        $result = preg_match("/".$routerSlashed."/", $uri, $matches);
        if($result == 1){
            unset($matches[0]);
            if(count($matches) > 0){
                sort($matches);
            }
            try{
                $controllerName = "\\src\\controller\\".$router["class"]."Controller";
                $controller = new $controllerName;
                $checkData  = $controller->check();
                $actionName = $router["action"];
                $templateFile = $router["template"];
                $templateFilePath = __DIR__."/src/view/".$templateFile;
                $returnValue = call_user_func_array(array($controller, $actionName), $matches);
                if($checkData != null){
                    $returnValue = array_merge($returnValue, $checkData);
                }
                if(!file_exists($templateFilePath)){
                    echo "404";exit;
                }
                $loader = new \Twig_Loader_Filesystem(__DIR__."/src/view");
                $twig = new \Twig_Environment($loader, []);
                $function = new Twig_SimpleFunction("generateUrl", "generateUrl");
                $twig->addFunction($function);
                $template = $twig->load($templateFile);
                echo $template->render($returnValue);
                $isUrlFound = true;
                break;
            }catch (\Exception $exception){

            }
        }
    }
    if(!$isUrlFound){
        echo "404";
    }
    exit;
}

function generateUrl($alias){
    global $routers;
    if(isset($routers[$alias])){
        return $routers[$alias]["url"];
    }
    return "";
}