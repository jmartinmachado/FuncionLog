## Funcion ws_debug()

Esta funcion imita a la funcion ws_debug() de Frontera2. Genera un archivo de log con el nombre del php que se ejecuto seguido de la fecha del dia. El nombre de la funcion es por una cuestion de comodida, a la hora de escribir el codigo; generalmente escribimos funciones y clases que son usadas tanto en frontera2 como por crones u otros scritps al tener el mismo nombre no nos tenemos que preocupar que el codigo va a romper en otro entorno. La funcion primero verifica que no exista otra funcion con el mismo y despues se define.

A la funcion le podemos pasar un cantidad 'infinita' de argumentos y los va imprimir uno por linea (Ver Ejemplo 3)

La funcion usa dos constantes que en caso de no estar definidas en el codigo las genera por defecto.

LOG_CARPETA: El path de la carpeta en donde deseamos guardar el log. Por defecto el path desde donde se esta ejecutando el codigo

AMBIENTE:  Si el valor de la constante es distinto PRODUCCION osea estamos trabajando en un entorno de testing y probando un cron desde la consola, la funcion imprime en la consola el log, ademas de guardar en un archivo. Esto es por una cuestion de comodidad por que no va hacer falta tener abierta otra consola con un tail -f al archivo de log. . El valor por defecto de esta constante es PRODUCCION.

## Uso

**Ejemplo 1:**
```
ws_debug("Inicio");
```
Imprime:
```
6479 2015-08-13 20:26:48 "Inicio"
```
**Ejemplo 2:**
```
$variable = array("Cosa1" => "Banana", "Cosa2" => "Naranja");
ws_debug($variable);
```
Imprime:
```
7315 2015-08-13 21:00:13 Array ( [Cosa1] => Banana [Cosa2] => Naranja )
```
**Ejemplo 3:**
```
$color = "verde";
ws_debug("Inicio", "el cielo es", $color, "probablemente");
```
Imprime:
```
7345 2015-08-13 21:01:51 Inicio
7345 2015-08-13 21:01:51 el cielo es
7345 2015-08-13 21:01:51 verde
7345 2015-08-13 21:01:51 probablemente
```# FuncionLog
