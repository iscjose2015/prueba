<?php
    function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
        |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
        , $_SERVER["HTTP_USER_AGENT"]);
    }

    function is_a_movil_OS(){ // Para obtener el S.O. del dispositivo desde donde se hace la petición (para definir la versión de jquery que se va a usar)
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if( strpos($user_agent, 'Android') !== false ){ // Si el sistema es Android
            return true;
        }else if( strpos($user_agent, 'iPhone') !== false ){ // Si el sistema es de iPhone
            return true;
        }else if( strpos($user_agent, 'iPad') !== false ){ // Si el sistema es de iPad
            return true;
        }else{ // Si el sistema no es de dispositivos móviles (al menos, de los que están arriba)
            return false;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>El Rey Del Tornillo</title>

    <!--Librerias js-->
<!--
    <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
-->
    <!--SCRIPT PARA EL FUNCIONAMIENTO-->
    <script src="js/val_emp_lgn.js"></script>
    <script src="js/jquery.min.js "></script>

    <script src="js/bootstrap.bundle.min.js "></script>
    <script src="js/plugin.js "></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js "></script>
    <!-- Para funciones generales -->
    <script src="js/lib.js"></script>




    <!-- BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    

    <!--SCRIPT PARA SABER SI ES MOVIL O ESCRITORIO-->
    <?php if(is_a_movil_OS()){ ?>
        <script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
        <?php
    }else{ ?>    
        <script src="js/jquery-3.6.0.min.js"></script>
    <?php } ?>
</head>




<?php
    include("conecta_rh.php");

    date_default_timezone_set('America/Mexico_City');
    $horaActual = date('H:i:s');
    $hoy = date("Y-m-d")."</br>";
    $hasta = date('Y-m-d', strtotime('-1 month'))."</br>"; // resta 1 mes


    $users  = $_POST['txtusuario'];
    $pass   = $_POST['txtpassword'];

        //Valida acceso
        $consultae = mysqli_query($con,"SELECT * FROM `empleados` WHERE numero_nomina = '$users' AND password = '$pass'");
        $total = mysqli_num_rows($consultae);
    
        if($total == 0){ echo "<script language='javascript'>window.parent.location='denegado.php'</script>"; }
        else {

            //Se obtiene tiempo actual
            //$tiempoActual = date('Y-m-d H:i:s');//Avisos nuevos
            //echo $tiempoActual;
            date_default_timezone_set('America/Mexico_City');
            $fecha_hoy = date("Y-m-d");

            //Se obtiene el id del empleado
            $sql = "SELECT id FROM empleados WHERE numero_nomina = $users";
            $res = mysqli_query($con, $sql);
            $arr = mysqli_fetch_array($res);
            $user_id = $arr[0];
            //echo $user_id;

            //$sql = "SELECT COUNT(*) FROM avisos as b LEFT JOIN notificaciones as a on a.id_aviso=b.id_aviso WHERE a.id= '".$user_id."' AND a.estatus = 0 ORDER BY f_envio DESC, f_aviso DESC limit 5";
            $sql = "SELECT COUNT(*) FROM empleados as a LEFT JOIN notificaciones as b on a.id=b.id LEFT JOIN avisos as c on b.id_aviso=c.id_aviso WHERE a.id= '".$user_id."' AND b.estatus = 0 AND c.f_aviso >= '".$fecha_hoy."'";
            $res = mysqli_query($con, $sql);
            $arr = mysqli_fetch_array($res);
            $total_avisos = $arr[0];
            //echo $total_avisos;

            $ree = mysqli_fetch_array($consultae);
            $clave = $ree['numero_nomina'];
            if(strlen($ree['tel_personal']) == 0){ echo '<script> window.parent.location="index.php?t=n&n='.$ree['numero_nomina'].'" </script>'; }
        }
?>


<body>
        <div class="Contact-bg"><!--INICIA ENCABEZADO-->
            <div class="container">
                <div class="row ">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ">
                        <div class="abouttitle "><img align="left" src="images/logoRey.fw.png" alt="" style="margin: 0 auto 0 1px;">/>
                            <h2 class="btn-primary">SIREU&nbsp;</h2>
                        </div>
                        <div id="closeSession" onclick="location.replace('index.php')"> <img src="images/close_sess.png" alt="Cerrar sesión" title="Salir"> </div>
                        <!--<div id="btn-mensajes" onclick="verMensajes('index.php')"> <img src="images/close_sess.png" alt="Ver mensaje" title="Mensajes"> </div>-->
                        <style>
                            html, body{
                                overflow-x: hidden;
                            }
                            #closeSession{
                                display: block;
                                position: absolute;
                                right: 3%;
                                top: 8%;
                            }
                            #closeSession:hover{
                                cursor: pointer;
                            }
                        </style>
                    </div>
                </div>            
            </div>
        </div><!--TERMINA ENCABEZADO-->


        <!--Obtiene usuario que puede agendar sala y registrar asistencia-->
        <?php
            //OPTENEMOS PERMISOS PARA HOMEOFFICE Y AGENDAR CITA
            $home = mysqli_query($con, "SELECT * FROM homeOffice WHERE numero_nomina = '$users'");
            $homeR= mysqli_fetch_array($home);
        ?>
        <!--Termina obtiener usuario que puede agendar sala y registrar asistencia-->


        <!--INICIA MENU-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active mx-auto">
                        <!--<a class="nav-link" name="inicio" id="inicio" href="" data-toggle="modal" data-target="#modal-inicio">Inicio <span class="sr-only">(current)</span></a>-->
                        <a class="nav-link" name="inicio" id="inicio">Inicio <span class="sr-only">(current)</span></a>
                    </li>

                    <?php if(($homeR['stts_agenda'] == 1)){ ?>
                        <li class="nav-item mx-auto">
                            <a class="nav-link" href="<?php echo 'reservaciones/index.php?n='. $users; ?>">Agendar sala de juntas</a>
                        </li>
                    <?php }?>
                    
                    <li class="nav-item mx-auto">
                        <a class="nav-link" href="<?php echo 'panel_avisos.php?n='. $users; ?>">Avisos</a>
                    </li>
                </ul>
            </div>
        </nav>

        <!--TERMINA MENU-->

        <br>
        <!-- Seccion datos trabajador -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <!--<h3 class="card-title">Crear nuevo aviso<a class="not-active" href = "#" data-toggle="modal" data-target="#modal-xl" ><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3>-->
                                <h3 class="card-title">Datos del trabajador</h3>
                            </div>

                            <div class="card-body">
                                <!--<div class="col">-->
								<img src="https://elreydeltornillo.com/sit/RH/pictures/<?php echo $ree['numero_nomina']; ?>.jpg" alt="No Foto" style="width: 153px; height: 177px; margin: 0 auto 0 96px;">
								<p>No de Nomina: <?php echo $ree['numero_nomina']; ?></p>
                                <p>Empleado: <?php echo $ree['nombre'];?></p>
                                

                                <!--</div>
                                <br>
                                <div class="col">-->
                                <!--Seccion botones-->
                                <button type="button" class="btn btn-success" name="btn-actualizar" id="btn-actualizar" data-toggle="modal" data-target="#modal-actualizar" onclick="datos_empleado('<?php echo $ree['numero_nomina'];?>', '<?php echo $ree['tipo'];?>', '<?php echo $ree['nombre'];?>', '<?php echo $ree['fecha_ingreso']?>', '2' );" style="margin:5px;">Actualizar datos</button>
<?php echo '<button type="button" class="btn btn-primary" name="btn-avisos" id="btn-avisos" onclick="cargarModal('.$user_id.')" style="margin:5px;">Avisos</button>';?>
<?php if($homeR['stts_home'] == 1){ ?>
    <button id="gps" class="btn btn-secondary" onclick="regisAsis(<?php echo $clave?>)" style="margin:5px;">Reg. Asistencia</button>
<?php } ?>
<button id="passChange" onclick="vacaciones('<?php echo $users?>', 'getvacaciones')" class="btn btn-info" style="margin:5px;">Vacaciones</button>

<!-- Botón "nomina" -->
<button type="button" class="btn btn-warning" name="btn-nomina" id="btn-nomina" style="margin:5px;" onmouseover="this.style.backgroundColor='#ff9900'" onmouseout="this.style.backgroundColor='#ffa500'">Nomina</button>

                                <!--Termina seccion botones-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Termina seccion datos trabajador-->

        <br>

        <!-- Seccion Asistencias trabajador -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Consulta de Asistencias</h3>
                                <h6>(Últimos 30 días)</h6>
                            </div>

                            <div class="card-body">

                                <table width="19%" class="table table-striped" id="example1"><!--TABLA PARA MOSTRAR LAS ASISTENCIAS-->
                                    <thead>
                                        <tr>
                                            <th width="30%">Fecha</th>
                                            <th width="39%">Registros</th>
                                            <th width="31%" style="width:25%;" >Dia Aut.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            //$dias = mysqli_query($con,"SELECT DISTINCT(fecha) FROM `asistencias` where fecha BETWEEN '$hasta' AND '$hoy' and idempleado = '$clave' order by 1 desc");
                                            $dias = mysqli_query($con,"SELECT DISTINCT(fecha) FROM `asistencias` where fecha BETWEEN '$hasta' AND '$hoy' and idempleado = '$clave' order by fecha desc");
                                            while( $re_dias = mysqli_fetch_array($dias)){ ?>
                                                <tr>
                                                    <td>
                                                        <?php 
                                                            echo  $fe = $re_dias['fecha'];
                                                        ?>		
                                                    </td>
                                                    <td class="horasTd"> 
                                                        <?php
                            
                                                            $consulta_asistencias = mysqli_query($con,"SELECT * FROM `asistencias`
                                                            where idempleado = '$clave' and fecha = '$fe'");

                                                            /*$consulta_min_max = mysqli_query($con,"SELECT  min(id) ini, max(id) fin  FROM `asistencias`
                                                            where idempleado = '$clave' and fecha = '$fe'" );
                                            
                                                            $re_min = mysqli_fetch_array($consulta_min_max);

                                                            $id_hora_inicial = $re_min['ini'];
                                                            $id_hora_final   = $re_min['fin'];

                                                            $consulta_hora_inicial = mysqli_query($con,"select * from asistencias where id = '$id_hora_inicial'");
                                                            $re_inicial = mysqli_fetch_array($consulta_hora_inicial);

                                                            $hora_inicial = $re_inicial['hora'];

                                                            $consulta_hora_final = mysqli_query($con,"select * from asistencias where id = '$id_hora_final'");
                                                            $re_final = mysqli_fetch_array($consulta_hora_final);

                                                            $hora_final = $re_final['hora'];*/
                                
                                                            while($re_asistencias = mysqli_fetch_array($consulta_asistencias)){
                                                                        
                                                                $cad = explode(":",$re_asistencias['hora']);
                                                                
                                                                $hor = $cad[0];
                                                                $min = $cad[1];
                                    
                                                                if($cad[0] == '01') {  $hor =  '01'; } 
                                                                if($cad[0] == '02') {  $hor =  '02'; } 
                                                                if($cad[0] == '03') {  $hor =  '03'; } 
                                                                if($cad[0] == '04') {  $hor =  '04'; } 
                                                                if($cad[0] == '05') {  $hor =  '05'; } 
                                                                if($cad[0] == '06') {  $hor =  '06'; } 
                                                                if($cad[0] == '07') {  $hor =  '07'; } 
                                                                if($cad[0] == '08') {  $hor =  '08'; } 
                                                                if($cad[0] == '09') {  $hor =  '09'; } 

                                                                if($cad[1] == '0') {  $min =  '00'; } 
                                                                if($cad[1] == '1') {  $min =  '01'; } 
                                                                if($cad[1] == '2') {  $min =  '02'; } 
                                                                if($cad[1] == '3') {  $min =  '03'; } 
                                                                if($cad[1] == '4') {  $min =  '04'; } 
                                                                if($cad[1] == '5') {  $min =  '05'; } 
                                                                if($cad[1] == '6') {  $min =  '06'; } 
                                                                if($cad[1] == '7') {  $min =  '07'; } 
                                                                if($cad[1] == '8') {  $min =  '08'; } 
                                                                if($cad[1] == '9') {  $min =  '09'; } 

                                                                echo '<div class="horasT">'.$hor.":".$min.'</div>';
                                                                            
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="horasTd">
                                                        <?php
                                                            $nomi = $ree['numero_nomina'];
                                                            $fe = $re_dias['fecha'];
                                                            
                                                            $aut = mysqli_query($con,"SELECT * FROM `autorizaciones` WHERE `numero_nomina` = '$nomi' and fecha = '$fe'");
                                                            $tot = mysqli_num_rows($aut);
                                                            
                                                            if ($tot >= '1'){ echo "Autorizado horas extras"; }
                                                        ?>
                                                    </td>
                                                </tr>
                                    <?php   } ?>
                                    </tbody>
                                </table><!--TERMINA TABLA PARA MOSTRAR LAS ASISTENCIAS-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Termina seccion asistencias trabajador-->








<!--Modal al iniciar sesion mostrar avisos-->
<script>
    <?php if($total_avisos>0) {?>
        $(function() {
            $('#modal-avisos').modal('toggle');
                loadDynamicContentModal(<?php echo $user_id;?>);
        });
    <?php } ?>
</script>
<!--Termina Modal al iniciar sesion mostrar avisos-->



<!--Funcion cargar modal con avisos desde boton-->
<script>
    function cargarModal(user_id){
        /*console.log("Entrando al loadDynamicContentModal()");
        console.log(user_id);
        console.log("Avisos sin leer:");
        console.log(<?php $total_avisos?>);*/

        <?php
            if($total_avisos > 0){
        ?>
              $("#modal-avisos").modal("show");
            
                loadDynamicContentModal(<?php echo $user_id;?>);
              
        <?php  
            }else{
        ?>
                $("#modal-sinAvisos").modal("show");

        <?php
            }
        ?>

    }

</script>
<!--Termina funcion cargar modal con avisos desde boton-->



<!--Para tabla responsive-->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<!--DataTable--> 
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.3/datatables.min.js"></script>


<!--Paginacion de tabla-->
<script>
    $(function () {
        $('#example1').DataTable({
          "order": [[ 0, "desc" ]],
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
        });
      }); 
</script>
<!--Termina paginacion de tabla-->

<!--Carga datos en modal al iniciar sesion-->
<script>
   function loadDynamicContentModal(user_id){
        //console.log("Entrando al loadDynamicContentModal()");
        //console.log(user_id);

        var options = {
            modal: true,
            height:300,
            width:600
        };
        // Realiza la consulta al fichero php para obtener información de la BD.
        $('.modal-body').load('obtenerAvisos.php?my_modal='+user_id, function() {
            $('#modal-avisos').modal({show:true});
        });  
        //console.log("Llega al final");

    }
</script>
<!--Termina Carga datos en modal al iniciar sesion-->



<!--MODALES-->
<!--Modal detalles-->
  <div class="modal fade" id="modal-avisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Avisos sin leer </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <?php 
            //$user_id = mysqli_query ($con, "SELECT id FROM empleados WHERE numero_nomina='$ree['numero_nomina']'");
            echo '<button class="btn btn-primary"  name="btn-mensajes" id="btn-mensajes" onclick=" location.replace(\'panel_avisos.php?n='.$ree['numero_nomina'].'\')">Ver avisos</button>';
        ?>
      </div>
    </div>
  </div>
</div>
<!--Fin carga datos en modal-->

<!--Modal sin avisos-->
<div class="modal fade" id="modal-sinAvisos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Avisos sin leer </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h>Usted no tiene avisos pendientes por leer</h2>

      </div>
      <div class="modal-footer">
        
        <button id ="btn-cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <?php 
            //$user_id = mysqli_query ($con, "SELECT id FROM empleados WHERE numero_nomina='$ree['numero_nomina']'");
            echo '<button class="btn btn-primary"  name="btn-mensajes" id="btn-mensajes" onclick=" location.replace(\'panel_avisos.php?n='.$ree['numero_nomina'].'\')">Ver avisos</button>';
        ?>
      </div>
    </div>
  </div>
</div>
<!--Fin modal sin avisos-->

<!--Inicia modal actualizar-->
      
<div class="modal fade" id="modal-actualizar">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Actualizar datos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card-body">

                    <!--<form id="form1" name="form1"> -->
                        
                        <div id="contenedor" class="row align-items-center">

                            <div class="row">
                                <label>No de Nomina:  <span id="dato-nomina"></span></label>
                                <label>Tipo: <span id="dato-tipo"></span></label>
                                <label>Nombre: <span id="dato-nombre"></span></label>
                                <label>Fecha de ingreso: <span id="dato-fechaIngreso"></span></label>
                                <!--<h5>Días de vacaciones por tomar: <span id="dato-vacaciones"></span></h5>-->
                            </div>

                        </div>

                        <!--Botones para actualizar-->
                        <div id="phoneNum">
                            <label>Telefono Celular</label>
                            <!-- or set via JS -->
                            <input type="text" name="telefono" id="telefono" value="<?php echo $ree['tel_personal'];?>" minlength="10" maxlength="10" size="10" onKeyPress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;">
                            <button class="btn btn-success" type="submit" onclick="updtContactData(<?php echo $ree['numero_nomina'];?>)">Actualizar</button>
                            <p id="onlyNum"></p>
                        </div><!--phoneNum-->
                        <br>
                            <div id="updtPass">
                                <!--<?php
                                //OPTENEMOS PERMISOS PARA HOMEOFFICE Y AGENDAR CITA
                                $home = mysqli_query($con, "SELECT * FROM homeOffice WHERE numero_nomina = '$users'");
                                $homeR= mysqli_fetch_array($home);
                                ?>-->

                                <button class="btn btn-success"  onclick="updtPassword('<?php echo $users;?>')">Cambiar contraseña</button>

                            </div><!--updtPass-->

                            <!--Termina botones actualizar-->


                            <div class="row">
                            <div class="modal-footer col-md-11 text-right">
                                <button id="btn-cerrarA" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="btn-actualizar" type="button" class="btn btn-success upload" data-dismiss="modal">Actualizar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Termina modal actualizar-->





<!--TERMINA MODALES-->


<!--Ver datos del empleado-->
<!--Ver contenido del aviso-->
    <script>
        function datos_empleado(nomina, tipo, nombre, fecha_ingreso, vacaciones){            
            //document.getElementById("d-notificacion").textContent=notificacion;
            document.getElementById("dato-nomina").textContent=nomina;  
            document.getElementById("dato-tipo").textContent=tipo;
            document.getElementById("dato-nombre").textContent=nombre;
            document.getElementById("dato-fechaIngreso").textContent=fecha_ingreso;
            document.getElementById("dato-vacaciones").textContent=vacaciones;
            //console.log(ruta);

        }
    </script>
<!--Termina ver datos del empleado-->

    <!--////////////////////MODAL DE SOLICITUD DE VACACIONES/////////////////////////-->
    <!--INCIIA PRIMER MODAL-->
    <div class="modal fade" id="modal_vacaciones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Vacaciones</h2>
                    <button type="button" class="btn-close" onclick="close_model()" aria-label="Close"></button>
                </div>
                <div class="modal-body"><!--CUERPO DEL MODAL-->
                    <div class="row g-2 table-responsive" ><!-- INICIA SECCION TABLA SOLICITUDES DE VACACIONES-->

                        <div class="card col-sm-12">
                            <div class="card-header">
                                <div class="container">
                                    <div class="row">
                                        <div class="col col-lg-6 text-start">
                                            <h6><strong>SOLICITUDES DE VACACIONES</strong></h6>
                                        </div>
                                        <div class="col col-lg-3 text-end">
                                            Dias Autorizados: <strong><label id="diasAutorizadas" value=""></label></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive" >

                                <div class="table-responsive">

                                    <table class="table" id="tblsolicitudes">
                                        <!--tbody id="tabla"-->
                                        <thead>
                                        <tr>
                                            <th><strong>&nbsp;</strong></th>
                                            <th><strong>Solicitud</strong></th>
                                            <th><strong>Fecha</strong></th>
                                            <th><strong>Motivo</strong></th>
                                            <th><strong>Estatus</strong></th>
                                        </tr>
                                        </thead>
                                        <!----AQUI VA EL SCRIPT----->
                                        <tbody>
                                        </tbody>
                                    </table>
                                
                                </div>

                            </div>
                        </div>

                        <!--DATOS OCULTOS-->
                        <input type="hidden" name="txtnomina" id="nomina-input" value=""/>
                        <!--DATOS OCULTOS-->

                    </div><!-- TERMINA SECCION TABLA SOLICITUDES DE VACACIONES-->
                </div><!--CUERPO DEL MODAL-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="close_model()">Cerrar</button>
                    <button class="btn btn-primary" onclick="calcula_vacaciones()">Solicitar vacaciones</button>
                    <!--data-bs-target="#solicitudvacaciones" data-bs-toggle="modal"-->
                </div>
            </div>
        </div>
    </div><!--TERMINA PRIMER MODAL-->

    <!--INICIA SEGUNDO MODAL-->
    <div class="modal fade" id="solicitudvacaciones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Vacaciones</h2>
                    <button type="button" class="btn-close" onclick="close_model2()" aria-label="Close"></button>
                </div>
                <form id="form1" name="form1" action="sendmail.php" method="POST">
                    <div class="modal-body"><!--CUERPO DEL SEGUNDO MODAL-->

                        <div class="card col-sm-12"><!-- INICIA SECCION DATOS DEL EMPLEADO-->
                            <div class="card-header">
                                <div class="container">
                                    <div class="row">
                                        <div class="col text-start">
                                            <h4><strong>Datos del Empleado</strong></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body table-responsive" >
                                    <div class="row g-2"><!-- INICIA SECCION 1--->
                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-6 col-form-label">Numero de empleado:</label>
                                                <div class="col-sm-6">
                                                    <input type="text" name="nomina" id="input-nomina"  placeholder="Nomina" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label">Nombre</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="txtnombre" id="input-nombre"  placeholder="Factura" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- TERMINA SECCION 1-->
                            </div>
                        </div><!-- TERMINA SECCION DATOS DEL EMPLEADO-->

                        <div class="card col-sm-12"><!-- INICIA SECCION PERIODO VACACIONES-->

                            <div class="card-header">
                                <div class="container">
                                    <div class="row">
                                        <div class="col text-start">
                                            <h4><strong>Periodo de vacaciones</strong></h4>
                                        </div>
                                    </div>

                                    <div class="container text-center">
                                        <div class="row">
                                            <div class="col">
                                            <h4>Años laborando: <strong><label id="anos"> 0</label></strong></h4>
                                            </div>
                                            <div class="col">
                                            <h4>Aniversario: <strong><label id="aniversario"> 0</label></strong></h4>
                                            </div>
                                            <div class="col">
                                            &nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="card-body table-responsive" id="periodo"><!-- INICIA BLOQUE Periodo de vacaciones--->
                                
                                    <div class="row g-2"><!-- INICIA BLOQUE 1 DIAS SOLICITADOS--->

                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-5 col-form-label text-end">Dias a solicitar: <strong><label id="input-diastotal">0</label></strong></label>
                                                <div class="col-sm-6 text-start">
                                                    <!--input type="text" name="txtdiastotal" id="input-diastotal"  placeholder="Dias" class="form-control" readonly-->
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-12 col-form-label text-start">Dias Disponibles: 
                                                        <strong>
                                                            <label class="form-label" id="data-diadisponible">0</label>
                                                        </strong>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-12 col-form-label text-start">Dias Tomados:
                                                        <strong>
                                                            <label class="form-label" id="data-diasolicitados">0</label>
                                                        </strong>
                                                </label>
                                            </div>
                                        </div>

                                    </div><!-- TERMINA BLOQUE 1-->
                                    </br>
                                    <div class="row g-2"><!-- INICIA BLOQUE 2 RANGO FECHAS--->

                                        <div class="col-sm-5 col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label text-end">Inicio</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="txtFinicio" id="input-finicio" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-5 col-md-6">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-3 col-form-label text-end">Final</label>
                                                <div class="col-sm-9">
                                                    <input type="date" name="txtFfinal" id="input-ffinal" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- TERMINA BLOQUE 2-->
                                    </br>
                                    <div class="row g-2"><!-- INICIA DIA FESTIVO--->
                                        <div class="col-sm-12 col-md-12">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-12 col-form-label text-start">
                                                    <strong>Dias Festivos año 2023: Si la solicitud contempla uno de estos dias, 
                                                        NO se sumara a la cantidad de dias solicitados!!
                                                    </strong><button type="button" class="btn btn-link" onclick="diasfestivos()">Dias Festivos</button>
                                                </label>
                                                <div class="col-sm-12 text-start">
                                                    <!--input type="text" name="txtdiastotal" id="input-diastotal"  placeholder="Dias" class="form-control" readonly-->
                                                                                                            
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- TERMINA INICIA DIA FESTIVO-->
                                    </br>
                                    <div class="row g-2"><!-- INICIA BLOQUE 3 OBSERVACIONES--->

                                        <div class="col-sm-5 col-md-12">
                                            <div class="form-group row">
                                                <label for="inputEmail3" class="col-sm-6 col-form-label">Observaciones</label>
                                                <div class="col-sm-12">
                                                    <div class="form-floating">
                                                        <textarea class="form-control" id="observa-input" name="txtobserva"></textarea>
                                                        <label for="floatingTextarea">Observaciones</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- TERMINA BLOQUE 3-->

                            </div><!-- TERMINA BLOQUE Periodo de vacaciones--->
                            <div class="card-body table-responsive" id="alert"><!-- BLOQUE ALERTE--->
                                <h6>
                                    USTED NO CUENTA CON DIAS DISPONIBLES DE VACACIONES!!</br>
                                    DIAS SOLICITADOS: <label id="diassolicitud">0</label></br>
                                    VERIFIQUE LA INFORMACION CON SU MANAGER!!
                                </h6>
                            </div><!-- BLOQUE ALERTE--->

                        </div><!-- TERMINA SECCION PERIODO VACACIONES-->

                        <!--DATOS OCULTOS-->
                            <input type="hidden" name="txttipouser" id="tipouser-input">
                            <input type="hidden" name="opc" value="insertsolicitud">
                        <!--DATOS OCULTOS-->
                            
                    </div><!--TERMINA CUERPO DEL SEGUNDO MODAL-->
                    <div class="modal-footer"><!--INICIA SECCION DE BOTONES-->
                        <button type="button" class="btn btn-secondary" onclick="close_model2()">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="btnsave">Guardar</button>
                        <!-- data-bs-target="#exampleModalToggle" data-bs-toggle="modal"-->
                    </div><!--TERMINA SECCION DE BOTONES-->
                </form>
            </div>
        </div>
    </div>
    <!--////////////////////MODAL DE SOLICITUD DE VACACIONES/////////////////////////-->
    <script src="js/usuarios.js"></script>
    <!--Datatables-->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>

</body>
</html>

<script>
    function regisAsis(nomina){
        $.ajax({
            url: 'home_office.php',
            data: {
                nomi: nomina
            },
            type: 'POST',
            success: (response) => {
                
                number_res = parseInt(response);
                response_options = { // Según la respuesta es el mensaje
                    0: '<p><?php echo $ree['nombre'];?></p><p>La hora es: '+getActualHour()+'</p>',
                    1: '<p>Sucedió un error al tratar de registrar su asistencia</p><p>Por favor vuelva a intentar y si el problema persiste, contacte al soporte.</p>',
                    2: '<p> Algo salió mal, por favor contacte al soporte</p>'
                };
                title_opt = {
                    0: 'Asistencia Remota',
                    1: 'Error',
                    2: 'Hubo un problema'
                }
                icon_opt = {
                    0: '<img src="https://img.icons8.com/material-rounded/344/home.png" title="Home">',
                    1: '<img src="https://img.icons8.com/ios-filled/344/x.png" title="Warning">',
                    2: '<img src="https://img.icons8.com/ios-filled/344/error-cloud--v1.png" title="Error">'
                }

                Swal.fire({
                    iconHtml: icon_opt[number_res],
                    title: title_opt[number_res],
                    html: response_options[number_res],
                    showConfirmButton: false,
                    showCloseButton: true,
                    allowOutsideClick: false
                }).then(() => {
                    window.location.reload();
                });
                
            },
            error: (jqXHR, textStatus) => {
                markErr(jqXHR, textStatus);
            }
        });
    };

    //MOSTRAMOS UN MSJ EN CASO DE INTRODUCIR TEXTO EN EL CAMPO DEL NUMERO CELULAR
    var alert = document.getElementById("onlyNum");
    document.getElementById("phoneNum").addEventListener("focus", () => alert.innerHTML = '<img src="images/warning.png" alt="Alerta!" title="Alerta"><b>Alerta: </b>Introduzca sólo números, por favor.', true);
    document.getElementById("phoneNum").addEventListener("blur", () => alert.innerHTML = ' ', true);
</script>