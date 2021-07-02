<template>
	<div>
		<div class="row justify-content-center m-2" v-if="form.srcfoto !== null">
			<div class="col-3">
				<div class="alert alert-info" ><b><i class="fas fa-camera"></i> 1 imagen tomada</b></div>
			</div>
		</div>
		<input type="hidden" :value="form.srcfoto"  @input="$emit('srcfoto', $event.target.value)">
		<div class="row mt-2">
	        <div class="col-12 text-center"> 
	          <a href="#"  @click.prevent="captureclick" class="btn btn-primary tomarimg"><i class="fa fa-camera" aria-hidden="true"></i> Tomar imagen</a>
	        </div>
	    </div>
		<div class="modal fade" id="fotomodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		    <div class="modal-dialog modal-lg" role="document">
		      <div class="modal-content">
		        <div class="modal-header">
		          <h5 class="modal-title" id="exampleModalLabel">Foto modal</h5>
		          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		            <span aria-hidden="true">&times;</span>
		          </button>
		        </div>
		        <div class="modal-body">

		        	<!--Iniciamos la grabadora de video-->
		     		<!--Esta seccion necesita estar escondida para usarla cuando toque -->

		        	<div class="row" :style="{'display':videstatus}">
		        		<div class="col-12 text-center">
		        			<video id="video" width="640" height="480" autoplay></video>
		        		</div>
		        	</div>

		        	<!--Iniciamos el canvas que obtendra la foto -->
		     		<!--El canvas estara como display none para mantenerlo escondido pero que podamos usarlo para otras cosas-->

		            <div class="row" :style="{'display':canvasstatus}">
		            	<div class="col-12 text-center">
		            		<canvas id="canvas" width="640" height="480" ></canvas>
		            	</div>
		            </div>
		            <div class="row"  >
		              <div class="col-12 text-center">
		                  <div class="row">
		                    <div class="col-12 text-center">

		                      <button v-if="box1 === null" class="btn btn-primary" id="snap" @click.prevent="captureget"><i class="fa fa-camera-retro" aria-hidden="true"></i> Capture</button>

		                      <button v-if="box1 !== null" class="btn btn-primary" id="return" @click.prevent="returncapture"><i class="fa fa-camera-retro" aria-hidden="true"></i> Tomar nuevamente o eliminar</button>
		                    </div>
		                 </div>
		              </div>
		           </div>
		        </div>
		      </div>
		    </div>
		</div>
		  
	</div>
</template>
<script>
	export default {
		props:['form'],
		data: function() {
	    	return {
	    		box1:null,
	    		//src_foto:null,
	    	}
	    },
	    computed:{
	    	canvasstatus(){
	    		return this.box1 !== null ? 'block' : 'none';
	    	},
	    	videstatus(){
	    		return this.box1 == null ? 'block' : 'none';
	    	}
	    },	
		methods:{
			captureclick(){

				let video = document.getElementById('video');
				let canvas = document.getElementById('canvas');
				let context = canvas.getContext('2d');

				$('#fotomodal').modal('show');

			    if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
			        navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
			            video.srcObject = stream;
			            video.play();
			            $("#fotomodal").on("hide.bs.modal", function () {
			                stream.getTracks().forEach(track => track.stop())
			            });
			        });
			    }
			},
			captureget(){
				let video = document.getElementById('video');
				let canvas = document.getElementById('canvas');
				let context = canvas.getContext('2d');

				context.drawImage(video, 0, 0, 640, 480);
			 	let dataUrl = canvas.toDataURL("image/png"); 

				this.box1 = dataUrl
				this.form.srcfoto = dataUrl
			   
			},
			returncapture(){
				this.box1 = null
				this.form.srcfoto = null
			}
		}
	}

</script>