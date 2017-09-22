        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/bootstrap-timepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/datepicker/jquery.datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/datepicker/jquery.datetimepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap-select/js/bootstrap-select.js"></script>
<!--        <script src="<?php echo base_url(); ?>assets/js/spec/js/TimepickerSpec.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/spec/js/MouseEventsSpec.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/spec/js/KeyboardEventsSpec.js"></script>-->


		<script>
			baseUrl = "<?php echo base_url(); ?>";
		    centerMap = {
		        lat: <?php echo (isset($lat)?$lat:'-34.5926653')?>,
		        lng: <?php echo (isset($lng)?$lng: '-58.5808747')?>,
		    }

			var mapa_camaras = JSON.parse('<?php echo $mapa_camaras; ?>');
			var mapa_zonas = JSON.parse('<?php echo $mapa_zonas; ?>');
		</script>
		<script src="<?php echo base_url();?>assets/js/plugins.js"></script>
        <script src="<?php echo base_url();?>assets/js/main.js"></script>
		<script src="<?php echo base_url();?>assets/js/maps.js"></script>
		<script src="<?php echo base_url();?>assets/js/vendor/markerclusterer.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GMAPS_API_KEY; ?>&callback=initMap&libraries=places"></script>
		<script src="<?php echo base_url();?>assets/js/maplabel.js"></script>
		 <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-71473510-2', 'auto');
		  ga('send', 'pageview');

		</script>

		<script type="text/javascript">
			var site_url = '<?php echo base_url(); ?>';
			var elem_height = 0;

			$(document).ready(function()
			{
				elem_height = $(".reportes-hor-container").height();

				$(".reportes-hor-container").css("height", 20);

				$(".reportes-hor-container").mouseenter(function()
				{
					$(this).stop(true, true).animate({
						height: elem_height
					}, 500).find(".handle").stop(true, true).fadeOut();
				});

				$(".reportes-hor-container").mouseleave(function()
				{
					$(this).stop(true, true).animate({
						height: 20
					}, 500).find(".handle").stop(true, true).fadeIn();
				});

				$("#evento_id").change(function()
				{
					id_evento = $(this).val();

					//console.log(id_evento);

					$.get(site_url + "/reportes/ajax_get_form/" + id_evento, function(data)
					{
						$('#form_dinamico').html(data);

						resizeForm();
					});
				});

				$(".hora_reporte_picker_new").keydown(function()
				{
					$(this).addClass("hora_input");
				});

				if($(".hora_reporte_picker_new").length > 0)
				{
					startTime();
				}

				$("#resetForm").click(function()
				{
					resetForm();
				});

				resizeForm();
			});

			function startTime()
			{
				var today = new Date();
				var h = today.getHours();
				var m = today.getMinutes();
				var ampm = (h < 12) ? "AM" : "PM";

				if(h > 12)
				{
					h = h - 12;
				}

				m = checkTime(m);

				if($(".hora_reporte_picker_new").hasClass("hora_input") == false)
				{
					$(".hora_reporte_picker_new").val(h + ":" + m + " " + ampm);
				}


				var t = setTimeout(startTime, 500);
			}

			function checkTime(i)
			{
				if(i < 10)
				{
					i = "0" + i;
				}

				return i;
			}

			function resetForm()
			{
				$('input[type=text], textarea').not("#fecha-picker, #hora_reporte_picker").val('');
				$('select').find('option').prop("selected", false);
				$('input[type=radio]').prop("checked", false);

				$('.selectpicker').selectpicker('refresh');
			}

			function resizeForm()
			{
				var form_static = 490;
				var w_height = $(window).height();

				$("#form_dinamico").css("height", w_height - form_static + "px");
			}
		</script>
    </body>
</html>
