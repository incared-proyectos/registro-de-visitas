<template>
	<div>
		<section-content>
		    <!-- Main row -->
		    <div class="row">
		    	<div class="col-12">
			     	<div class="card">
			     	   <div class="card-header bg bg-info">
			     	   		<div class="row">
			     	   			<div class="col-6">
			     	   				<b><i class="fas fa-eye"></i>  <i class="fas fa-plus-square"></i>  Formulario Visita Edicion</b>
			     	   			</div>
			     	   			<div class="col-6 text-right text-white">
			     	   				<a @click="$router.go(-1)" href="#">				                        
			     	   					<b class="text-white"><i class="fas fa-arrow-alt-circle-left"></i> Atras..</b>
									</a>

			     	   				
			     	   			</div>
			     	   		</div>
			     	   </div>
		              <div class="card-body">
					    <errors-form :errors="validationForm"/>
						<success-message :message="message_success"/>

		              	<form action="" @submit.prevent="saveform">
		              		<!--Inputs selects y otros en un componente llamado head-form-->
		              		<head-form 
			              		:form="form"
			              		type="edit"

			              		@nombre="form.nombre = $event"
								@dni="form.dni = $event"
								@itemjson="form.itemsjson = $event"
								@lugar="form.lugar = $event"
		              		/>

		              		<input-dynamic
		              			:form="form"
		              			:inputs="inputs"
		              			@inputarray="inputs = $event"
								@herramientastatus="form.herramientastatus = $event"

		              		/>

		              		<!--Componente para tomar la foto mediante un modal -->
		              		<foto-modal
		              		editform="true"

		              		:form="form"
		              		/>

		              		<div class="row mt-3">
		              			<div class="col-12 text-center">
		              				<button class="btn btn-primary" ><i class="fas fa-save"></i> Guardar</button>
		              			</div>
		              		</div>
		              	</form>
		              </div>
		            </div>
		     	</div>
		    </div>
		    <!-- /.row (main row) -->
		</section-content>

	</div>
</template>
<script>
	import SectionContent from "@/components/SectionContent.vue"
	import HeaderTitle from "@/components/HeaderTitle.vue"
	import HeadForm from "@/components/visitas/head.vue"
	import FotoModal from "@/components/visitas/FotoModal.vue"
	import InputDynamic from "@/components/visitas/InputDynamic.vue"
	import ErrorsForm from "@/components/ValidationErrors.vue"
	import successMessage from '@/components/SuccessMessage.vue';
	import Modal from '@/components/Modal.vue';

	export default {
		components:{
			SectionContent,HeaderTitle,HeadForm,FotoModal,successMessage,ErrorsForm,Modal,InputDynamic
		},
		created(){
			this.init();
		},
		data: function() {
			return {
				form:{
					nombre:'',
					dni:'',
					lugar:'',
					herramientastatus:'',
					srcfoto:null,
					fecha_programada:null,

					itemsjson:{
						entidad:{id:0,name:'-'},
		    			empleado:{id:0,name:'-'},
		    			sede:{id:0,name:'-'},
		    			oficina:{id:0,name:'-'},
		    			motivo:{id:0,name:'-'}
	    			},
				},

				inputs:[],

				validationForm:[],
	    		message_success:'',
	    		fullPage: false
			}
		},
		methods:{
			async init() {
			  try {
			    const response = await axios.get(route('visitas.edit',{id:this.$route.params.id}));
			 	if (response.data === '') {
			    	this.$router.push({ path: '/visitas' })
			    }
			    this.form = response.data

			  } catch (error) {
			    console.error(error);
			  }
			},
			loader(){
	    		return this.$loading.show({
                  // Optional parameters
                  container: this.fullPage ? null : this.$refs.formContainer,
                  canCancel: false,
                  onCancel: this.onCancel,
                });
	    	},
	    	resetmessage(){
	    		let me =  this;
	    		setTimeout(function(){ me.message_success = '' ;me.validationForm = [];}, 7000);
	    	},
	    	clearform(){
        		let me = this;
        		Object.keys(this.form).forEach(function(key) {
        		  if (Array.isArray(me.form[key]) ) {
        		  	me.form[key] = []
        		  }else{
				  	me.form[key] = null;
				  }
				})
        	},
        
			saveform(){
				let loader = this.loader();
	    		let me = this;
	    		this.form.inputs = this.inputs

				axios.post(route('visitas.update'),this.form)
			  	.then(function (response) {

			  		me.validationForm = ''
	    		    location.reload();
			    	
			  	})
			  	.catch(function (error) {
			    	loader.hide()
	    			me.validationForm = ''
	    		  	if (error.response.status == 422){
			    		me.validationForm = error.response.data;
			      	}else if (error.response.status == 500) {
			        	alert(error.response.data.message)
			      	}
			  	});
			}
		},
		mounted(){

		}
	}
</script>