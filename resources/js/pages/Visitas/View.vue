<template>
	<div>
		<section-content>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header bg bg-info">
			     	   		<div class="row">
				     	   		<div class="col-6">
				     	   				<b><i class="fas fa-eye"></i> Visitas View</b>
				     	   		</div>
			     	   			<div class="col-6 text-right">
			     	   				<router-link  to="/visitas" class="text-white">
				                        <b><i class="fas fa-arrow-alt-circle-left"></i> Volver al listado..</b>
				                    </router-link>
			     	   			</div>
		     	   			</div>
			     	   	</div>
			     	   	<div class="card-body">

							<form action="">
								<div class="row">
									<div class="col-4">
										<label for="">NOMBRE Y APELLIDO</label>
										<input type="text" readonly=""  class="form-control" v-model="form.nombre">
									</div>
									<div class="col-4">
										<label for="">DNI</label>
										<input type="text" readonly="" class="form-control" v-model="form.dni" >
									</div>
									<div class="col-4">
										<label for="">ENTIDAD</label>
										<input type="text" readonly=""  class="form-control" v-model="jsonselects.entidad.name">
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-4">
										<label for="">MOTIVO</label>
										<input type="text" readonly="" class="form-control" v-model="jsonselects.motivo.name">
									</div>
									<div class="col-4">
										<label for="">EMPLEADO</label>
										<input type="text" readonly="" class="form-control" v-model="jsonselects.empleado.name">

									</div>
									<div class="col-4">
										<label for="">SEDES</label>
										<input type="text" readonly="" class="form-control" v-model="jsonselects.sede.name">
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-6">
										<input type="text" readonly="" class="form-control" v-model="form.lugar">

									</div>
									<div class="col-6">
										<input type="text" readonly="" class="form-control" v-model="jsonselects.oficina.name">
									</div>
								</div>
								<div class="row justify-content-center m-2" v-if="form.srcfoto !== null">
									<div class="col-3">
										<div class="alert alert-info" >
											<b><i class="fas fa-camera"></i> 1 imagen tomada</b>   
											<a href="#"  @click.prevent="showimgsave"> <b>Ver imagen guardada</b></a>
										</div>
									</div>
								</div>
								<modal 
								:showModal="showModal"
								:key="componentKey">
									<template v-slot:header>
									    Imagen de la visita</b>
									</template>
							    	<img :src="`${srcmodal}`" alt="" class="img-fluid w-100"/>
							    </modal>
								<!--Inputs Guardados -->
								<div class="row mt-5" v-for="(item,index) in form.herramientas" :key="item.id">
									<div class="col-4 text-center">
										<label for="" class="text-uppercase ">Herramienta de trabajo</label>
										<input type="text"  v-model="item.nombre"  class="form-control" readonly="">
									</div>
									<div class="col-4  text-center">
										<label for="" class="text-uppercase ">Marca</label>

										<input type="text" v-model="item.marca" class="form-control" readonly="">
									</div>
									<div class="col-4 text-center">
										<label for="" class="text-uppercase ">Serial</label>

										<input type="text" v-model="item.serial" class="form-control" readonly="">
									</div>
									
								</div>
								<!--////-->
							</form>
						</div>
					</div>
				</div>
			</div>
		</section-content>
	</div>
</template>
<script>
	import SectionContent from "@/components/SectionContent.vue"
	import HeaderTitle from "@/components/HeaderTitle.vue"
	import Modal from '@/components/Modal.vue'

	export default {
		components:{
			SectionContent,HeaderTitle,Modal
		},
		data: function() {
			return {
				showModal:false,
				componentKey:0,
				jsoninputs:{
	    			entidad:{id:0,name:'-'},
	    			empleado:{id:0,name:'-'},
	    			sede:{id:0,name:'-'},
	    			oficina:{id:0,name:'-'},
	    			motivo:{id:0,name:'-'}
	    		},
	    		form:{
					nombre:'',
					dni:'',
					lugar:'',
					herramientastatus:'',
					srcfoto:null,
					itemsjson:null,
				},
			}
		},
		created(){
			this.init();
		},
		computed:{
			jsonselects(){
				return (this.form.itemsjson !== null ) ? this.form.itemsjson : this.jsoninputs
			},
			srcmodal(){
	    		return  `${base_path_asset}storage/Visitas/${this.form.srcfoto}`
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
			showimgsave(){
				this.showModal = true
				this.componentKey +=1
			}
		}
	}
</script>