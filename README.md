# ############################################## #
# ######## GUÍA DE USO PARA LA API REST ######## #
# ############################################## #

# ########################################## #
# <<<<<< ``JUAN SEBASTIAN MEDINA TORO`` >>>>>>
# ########################################## #

# -------------------------------------------------------------- #
# ``Condiciones técnicas``:
#   Versión de PHP    : ``8``
#   Herramienta       : ``XAMPP``
#   Base de Datos     : ``MariaDB/MySQL``
#   Puerto de trabajo : ``80``
#   Usuario           : ``root``
#   Password          : `` `` sin password
#   URL general       : ``http://localhost:80/api-mini-tickets``
#   Probar endpoints  : ``POSTMAN``
# -------------------------------------------------------------- #

# Proceso de ejecución:
#   ``1. Instalación``
    * Una vez instalado XAMPP o el motor de trabajo de preferencia, cree una base de datos con el nombre ((((  tickets_db  )))) sin parentesis ni espacios
    * Importe a la base de datos anterior el archivo .sql alojado en la carpeta database de este proyecto (se que no es una buena práctica ni mucho menos seguro, pero para terminos de revisión de la API lo harémos de esta manera)
    * La base de datos vendrá con algunos datos.
    * Se usará el archivo .htaccess para manejar las URL amigables
#   ``2. Uso``
    * Usando la herramienta POSTMAN, compruebe las URL, se anexa la colección POSTMAN usada, sin embargo, se deja consolidado en este archivo los endpoint.
    * Cada endpoint irá acompañado con el nombre de la tabla (si dado el caso mas adelante queremos usar este mismo para otras tablas de la BD)


#       GET (Obtener el listado de tickets paginados SIN FILTRO) -> ``Usando params y elementos limit y order de SQL``
            * http://localhost:80/api-mini-tickets/tickets?orderBy=usuario&orderMode=desc&startAt=0&endAt=5
#               Explicación:
                    * tickets = Nombre de la tabla
                    * orderBy = Nombre de columna de la tabla para ordenar
                    * orderMode = Si vamos a ordenar ASC o DESC
                    * startAt = Para el tema de la paginación, desde donde arranca el muestreo de la data
                    * endAt   = Para el tema de la paginación, hasta donde llega el muestreo de la data


#       GET (Obtener el listado de tickets paginados CON FILTRO) -> ``Usando params para enviar la busqueda y elementos limit y order de SQL``
            * http://localhost:80/api-mini-tickets/tickets?linkTo=usuario&equalTo=medina&orderBy=usuario&orderMode=desc&startAt=0&endAt=4
#               Explicación:
                    * tickets = Nombre de la tabla
                    * linkTo = Columna por la que voy a realizar la busqueda
                    * equalTo = Valor por el que voy a realizar la busqueda (En la sentencia SQL estamos usando un LIKE)
                    * orderBy = Nombre de columna de la tabla para ordenar
                    * orderMode = Si vamos a ordenar ASC o DESC
                    * startAt = Para el tema de la paginación, desde donde arranca el muestreo de la data
                    * endAt   = Para el tema de la paginación, hasta donde llega el muestreo de la data


#       POST (Agregar un Ticket) -> ``Usamos el Body del tipo: x-www-form-urlencoded``
            * http://localhost:80/api-mini-tickets/tickets
#               Explicación:
                    * El Body lo enviamos como x-www-form-urlenconded
                    * El nombre de los parámetros debe ser igual al nombre de las columnas en la BD
                        - Las columnas se calculan dinámicamente, por tanto, es importante esta definición


#       PUT (Actualizar un Ticket) -> ``Usamos el Body del tipo: x-www-form-urlencoded``
            * http://localhost:80/api-mini-tickets/tickets?nameId=id&id=10
#               Explicación:
                    * tickets = Nombre de la tabla
                    * nameId = Nombre de la columna que se actualizará
                    * id = Valor de la columna a actualizar


#       DELETE (Eliminar un Ticket) -> ``Usamos el Body del tipo: x-www-form-urlencoded``
            * http://localhost:80/api-mini-tickets/tickets?nameId=id&id=10
#               Explicación:
                    * tickets = Nombre de la tabla
                    * nameId = Nombre de la columna que se eliminará
                    * id = Valor de la columna a eliminar

#   ``3. Configuración``
    Se anexa el archivo collection de postman con las peticiones de prueba, revisar la carpeta config del proyecto