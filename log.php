<?php
/**
 * Descripción: Log
 *
 * @category Categoria
 * @package  Helpers
 * @author   Machado, Juan Martín <machado.juanmartin@gmail.com>
 * @license  www.juanmartinmachado.com.ar
 * @version  1.0.0
 * @link     jmartinmachado, https://github.com/jmartinmachado/FuncionLog
 *
 * @internal Fecha de creación:   2016-01-19
 * @internal Ultima modificación: 2016-01-19
 *
 * @internal Audit trail
 * (AAAA-MM-DD) Autor: Modificación
 */

/**
 * AutoLoad
 */
require_once dirname(__FILE__) . "/vendor/autoload.php";

/**
 * Logger
 */
require_once dirname(__FILE__) . "/vendor/apache/log4php/src/main/php/Logger.php";

/**
 * Defino por defecto las constantes de la funcion
 */
if (!defined("LOG_CARPETA")) {
    define("LOG_CARPETA", dirname("__FILE__"));
}

if (!defined("AMBIENTE")) {
    define("AMBIENTE", "PRODUCCION");
}

if (!defined("LOG_MAXFILESIZE")) {
    define("LOG_MAXFILESIZE", "5MB");
}

if (!defined("LOG_MAXBACKUPINDEX")) {
    define("LOG_MAXBACKUPINDEX", "5");
}


/**
 * Genero el nombre del archivo
 */
if (!defined("LOG_NOMBRE")) {
    $nombrelogs = LOG_CARPETA . basename($_SERVER["SCRIPT_NAME"], ".php").".log";
} else {
    $nombrelogs = LOG_CARPETA . LOG_NOMBRE . ".log";
}

$appenders = array('rotacion');
if (AMBIENTE != 'PRODUCCION') {
    $appenders[] = 'consola';
}

/**
 * Configure el Logger
 */
Logger::configure(
    array(
        'appenders' => array(
            'consola' => array(
                'class' => 'LoggerAppenderConsole',
                'layout' => array(
                    'class' => 'LoggerLayoutPattern',
                    'params' => array(
                        'conversionPattern' => '%pid %date{Y-m-d H:i:s} %-5level %msg%n'
                    )
                )
            ),
            'rotacion' => array(
                'class' => 'LoggerAppenderRollingFile',
                'layout' => array(
                    'class' => 'LoggerLayoutPattern',
                    'params' => array(
                        'conversionPattern' => '%pid %date{Y-m-d H:i:s} %-5level %msg%n'
                    )
                ),
                'params' => array(
                    'file' => $nombrelogs,
                    'maxFileSize' => LOG_MAXFILESIZE,
                    'maxBackupIndex' => 5,
                    'append' => true
                )
            )
        ),
        'rootLogger' => array(
            'appenders' => $appenders,
        )
    )
);


if (!function_exists("ws_debug")) {
    $log = Logger::getLogger(basename($_SERVER["SCRIPT_NAME"], ".php"));

    /**
     * Debug
     *
     * @return void
     *
     * @author Juan Martin Machado
     *
     * @internal Fecha de creación: 2016-01-19
     * @internal Ultima modificación: 2016-01-19
     * @internal Razón: Creacion
     */
    function ws_debug()
    {
        /**
         * Me conecto con el archivo
         */
        $log = Logger::getLogger(basename($_SERVER["SCRIPT_NAME"], ".php"));

        /**
         * Guardo en disco
         */
        $argumentos = func_get_args();
        foreach ($argumentos as $argumento) {
            $log->debug(logHelper($argumento));
        }
    }
}

if (!function_exists("ws_info")) {
    /**
     * Debug
     *
     * @return void
     *
     * @author Juan Martin Machado
     *
     * @internal Fecha de creación: 2016-01-19
     * @internal Ultima modificación: 2016-01-19
     * @internal Razón: Creacion
     */
    function ws_info()
    {
        /**
         * Me conecto con el archivo
         */
        $log = Logger::getLogger(basename($_SERVER["SCRIPT_NAME"], ".php"));

        /**
         * Guardo en disco
         */
        $argumentos = func_get_args();
        foreach ($argumentos as $argumento) {
            $log->info(logHelper($argumento));
        }
    }
}

/**
 * Helpers
 * @return string texto de logs
 * @param  obj $argumento Objetos a logear
 */
function logHelper($argumento)
{
    /**
     * Genero la entrada para cada argumento
     */
    $texto = "";
    switch (gettype($argumento)) {
    case 'string':
        $texto = $argumento ;
        break;
    default:
        ob_start();
        var_dump($argumento);
        $texto .= ob_get_contents();
        ob_end_clean();
        break;
    }
    return $texto;
}


