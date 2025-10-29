<style>
  /* CONFIGURACIÓN BASE: Reseteo y Fuente */
  * { 
    margin: 0; 
    padding: 0; 
    border: 0; 
    box-sizing: border-box; 
    font-family: DejaVuSans;
  }

  /* --- Encabezado del Documento (Logo y Título) --- */
  .header-content {
      /* Usa display: inline-block y float para lograr alineación lateral
         en muchos generadores de PDF basados en HTML como mPDF */
      width: 100%;
      text-align: center; /* Alineación por defecto */
      margin-bottom: 20px;
  }
  
  .logo {
      width: 60px; /* Tamaño del logo */
      height: 60px; 
      float: left; /* Alinea la imagen a la izquierda */
      margin-right: 20px; /* Separación con el título */
  }

  .title {
      /* Estilo del título formal */
      color: #0d6efd;
      font-size: 16px; 
      line-height: 1.2;
      border-bottom: 2px solid #0d6efd;
      padding-bottom: 5px;
      margin-top: 5px; /* Ajuste vertical */
      padding-top: 5px; /* Ajuste vertical */
      text-align: center;
  }
  
  /* Limpiar el float para que el contenido siguiente no se rompa */
  .header-content::after {
      content: "";
      display: table;
      clear: both;
  }
  

  /* --- Estilos de la Tabla --- */
  .tabla {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Crucial para respetar los anchos de columna */
  }

  .tabla td, .tabla th {
    border: 0.5px solid #000;
    padding: 6px 4px; 
    vertical-align: top; /* Alinear contenido en la parte superior de la celda */
  }

  .tabla thead th {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 11.5px;
    padding: 8px 4px;
  }
  
  /* Asegura que el contenido largo se ajuste y no desborde la celda */
  .detail-col {
      word-wrap: break-word; 
      overflow-wrap: break-word;
  }
  
  /* Estilo para la fila cuando no hay registros */
  .no-records {
      padding: 15px;
      font-style: italic;
      color: #6c757d;
  }


  /* --- Utilidades de Alineación y Formato --- */
  .text-center { text-align: center; }
  .text-left { text-align: left; }
  .text-end { text-align: right; }
  .text-justify { text-align: justify; }

  .text-nowrap { white-space: nowrap; } /* Mantiene Fecha y Hora en una sola línea (si cabe) */

  /* --- Utilidades de Espaciado (Ajuste para PDF) --- */
  .mb-1{ margin-bottom: 5px; }
  .mb-2{ margin-bottom: 10px; }
  .mb-3{ margin-bottom: 15px; }

  .mt-1{ margin-top: 5px; }
  .mt-2{ margin-top: 10px; }
  .mt-3{ margin-top: 15px; }
  
  /* --- Utilidades de Color --- */
  .bg-secondary{ background-color: #6c757d; }
  .bg-primary{ background-color: #0d6efd; } /* Azul Principal */
  .bg-danger{ background-color: #dc3545; }

  .text-light{ color: #fff; }
</style>
