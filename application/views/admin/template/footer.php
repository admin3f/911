
		</div>

                <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.1/less.min.js"></script>
                <script type="text/javascript" src="<?php echo base_url();?>assets/prettify/prettify.js"></script>
		<script src="<?php echo base_url();?>assets/js/vendor/bootstrap.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/listado.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/datepicker/jquery.datetimepicker.js"></script>
		        <script src="<?php echo base_url(); ?>assets/bootstrap-select/js/bootstrap-select.js"></script>
		<script type="text/javascript">
			$(function(){-
    			$('.selector-fecha').datetimepicker({timepicker: false, format:'d-m-Y', lang: 'es'});
    			//$('.selector-fecha').datetimepicker.setLocale('es');

			});

		</script>
		
		<?php if(isset($print)){
					echo $print;
				}
		?>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-71473510-2', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>