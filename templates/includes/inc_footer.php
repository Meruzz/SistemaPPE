  <!-- inc_footer.php -->
  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

</head>
<body id="page-top">

<div id="content-wrapper">

    <!-- Aquí va el resto de tu contenido -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white footer">
        <div class="container my-auto">
            <div class="text-center my-auto">
                <span>Todos los derechos reservados &copy; <?php echo get_sitename(); ?> <?php echo date('Y'); ?></span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->


  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Estas seguro?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body"><?php echo sprintf('Seleccione "Cerrar sesión" si estas listo para salir de %s.', get_sitename()) ?></div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="logout">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </div>

  <?php require_once INCLUDES . 'inc_scripts.php'; ?>
  </body>

  </html>