<footer id="footer" class="footer-v3 align-left">
    <!-- End container -->
    <div class="footer-bottom box">
      <div class="container container-ver2">
          <div class="box bottom">
              <p class="float-left">Copyright &copy;{{date('Y')}} ruteksa.com - All Rights Reserved.</p>
              <div class="social float-right">
                <a href="https://www.instagram.com/paksayurcom/" title="t"><i class="fa fa-instagram"></i></a>
                <a href="http://wa.me/6281241938647" title="f"><i class="fa fa-whatsapp"></i></a>
              </div>
          </div>
      </div>
      <!-- End container -->
    </div>
</footer>
</div>
<!-- End wrappage -->
<script type="text/javascript" src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/jquery.themepunch.revolution.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/jquery.themepunch.plugins.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/engo-plugins.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('frontend/js/store.js')}}"></script>
<script src="{{asset('backoffice/vendor/parsleyjs/parsley.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(".validasi").parsley();
    $(".datepicker").datepicker({
         format: 'yyyy-mm-dd',
         autoclose: true,
         startDate: "+1d"
    });
</script>