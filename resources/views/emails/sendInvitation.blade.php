<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
  </head>
  <body>
  <style type="text/css">
    .boton{
      text-decoration: none;
      padding: 10px;
      font-weight: 600;
      font-size: 14px;
      color: #ffffff;
      background-color: #0F6664;
      border-radius: 5px;
      border: 1px solid #1BA6A4;
    }

    .boton:hover{
      background-color: #16A19E;
    }
  </style>
    <h2>Invitación al equipo NES-BMP</h2>
    <p>En hora buena!!<br>
      Has sido invitado a ser parte del equipo <b>NES-BMP</b>. Si decides aceptar la invitación haz click en el link de abajo y coloca las credenciales adjuntas a este correo</p>
    <p>Usuario: {{$email}}</p>
    <p>Contraseña provisional: {{$password}}</p>
    <a class="boton" href="{{$url}}">Verificar</a>
    <p>{{ $url }}</p>
  </body>
</html>
