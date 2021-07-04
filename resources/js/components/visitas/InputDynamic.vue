<template>
	<div>
		<div class="row mb-2">
			<div class="col-12 text-center">
				<label for=""><b>Seleccione si tiene una herramienta</b></label>
				<br>
				Si <input type="radio" value="si"  name="checks" :checked="form.herramientastatus == 'si' ? true : false "  @change="checkinput" required="" >
				No <input type="radio" value="no"  name="checks" :checked="form.herramientastatus == 'no' ? true : false "  @change="checkinput" required="" >
			</div>
		</div>


		<!--Este div contiene los inputs que se crean de forma dinamica, de este modo validamos que los podamos crear y eliminar -->
		<div v-if="checkherramienta">
			<div class="row">
				<div class="col-12 text-center">
			   		<a href="#" @click.prevent="inputadd"><i class="fas fa-plus-circle"></i></a>
			   	</div>
			</div>

			<div v-if="typeof form.herramientas !== 'undefined'">
				<!--Inputs Guardados -->
				<div class="row mt-5" v-for="(item,index) in form.herramientas" :key="item.id">
					<div class="col-4 text-center">
						<label for="" class="text-uppercase ">Herramienta de trabajo</label>
						<input type="text"  v-model="item.nombre"  class="form-control">
					</div>
					<div class="col-3 text-center">
						<label for="" class="text-uppercase ">Marca</label>

						<input type="text" v-model="item.marca" class="form-control">
					</div>
					<div class="col-3 text-center">
						<label for="" class="text-uppercase ">Serial</label>

						<input type="text" v-model="item.serial" class="form-control">
					</div>
					<div class="col-2 text-center">
						<label for="" class="text-uppercase ">Eliminar</label>
						<br>
						<a href="#" @click.prevent="deleteinputDB(item.id,index)"><i class="fas fa-trash" style="font-size:31px;"></i></a>
					</div>
				</div>
			</div>
			<!--////-->

			<!--Inputs Nuevos -->
			<div class="row mt-5" v-for="(input, index) in inputs" :key="index">
				<div class="col-4 text-center">
					<label for="" class="text-uppercase ">Herramienta de trabajo</label>
					<input type="text"  v-model="input.value_herramienta"  class="form-control">
				</div>
				<div class="col-3 text-center">
					<label for="" class="text-uppercase ">Marca</label>

					<input type="text" v-model="input.value_marca" class="form-control">
				</div>
				<div class="col-3 text-center">
					<label for="" class="text-uppercase ">Serial</label>

					<input type="text" v-model="input.value_serial" class="form-control">
				</div>
				<div class="col-2 text-center">
					<label for="" class="text-uppercase ">Eliminar</label>
					<br>
					<a href="#" @click.prevent="deleteinputNew(index)"><i class="fas fa-trash" style="font-size:31px;"></i></a>
				</div>
			</div>
			<!--////-->

		</div>
	</div>
</template>
<script>
	export default {
		props:['form','inputs'],
		data: function() {
			return{
				checkherramientas:false
			}
		},
		computed:{
			//Chequeamos que la herramienta venga con estatus de si 
			checkherramienta(){
				return this.form.herramientastatus == 'si' ? true : false
			}
		},
		methods:{
			//Cuando el radio cambie de valor validamos y lo enviamos a la vista 
			checkinput(event){
				let valradio = event.currentTarget.value
				this.checkherramientas = (valradio == 'si' ) ? true : false

				this.$emit('herramientastatus',valradio)
			},
			//*****************************//
			//Funciones para  nuevos inputs//
			//*****************************//
			inputadd(){

				this.inputs.push(
					{
						value_herramienta:'',
						value_marca:'',
						value_serial:''
					}
				)
				this.$emit('inputarray',this.inputs)
			},
			deleteinputNew(index){
  				this.inputs.splice(index, 1);
			},
			///---------END----------------///

			//*****************************//
			//Funciones para inputs DB //
			//*****************************//
			deleteinputDB(id,index){
  				
	            swal.fire({
	              title:'Estas seguro?',
	              text: "Esta accción es irreversible",
	              icon: 'warning',
	              showCancelButton: true,
	              confirmButtonColor: '#3085d6',
	              cancelButtonColor: '#d33',
	              confirmButtonText: 'Si, eliminar!'
	            }).then((result) => {
	            	if (result.isConfirmed) {  
		  				axios.post(route('herramientas.delete'), {id}).then((response) => {
		  				  this.form.herramientas.splice(index, 1);
		  				}).catch((error) => {
		  				  console.error(error);
		  				})
	  				}
  				})
			}
			///---------END----------------///
			
		},
	}
</script>