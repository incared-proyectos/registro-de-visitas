<template>
	<div>
		<section-content>
		    <!-- Main row -->
		    <div class="row">
		    	<div class="col-12">
			     	<div class="card">
			     	   <div class="card-header bg bg-info">
			     	   		<b><i class="fas fa-eye"></i> Visitas</b>
			     	   </div>
		              <div class="card-body">
	              		<div class="row mb-2">
	              			<div class="row">
	              				<div class="col-12">
	              					<router-link  to="/visitas/create"  class="btn btn-primary">
							            <i class="fas fa-plus-square"></i>
							            <b> ADD</b>
							         </router-link>
	              				</div>
	              			</div>
	              		</div>
	              		<div class="row justify-content-center">
	              			<div class="col-2">
	              				<label for="" class="m-0">Desde:</label>
	              				<VueDatePicker v-model="fechaDesde" @onChange="tablesearch" ></VueDatePicker>

	              			</div>
	              			<div class="col-2 ">
	              				<label for="" class="m-0">Hasta:</label>

	              				<VueDatePicker v-model="fechaHasta" @onChange="tablesearch" ></VueDatePicker>
	              			</div>
	              		</div>
	              		<hr>
	              		<div class="row justify-content-center mt-2">
	              			<div class="col-4 text-center " style="margin-right: 96px;">
	              				<button class="btn btn-primary" @click="resetfilters"><i class="fas fa-sync"></i> <b>RESET</b></button>
	              			</div>
	              		
	              		</div>
		                <div class="table-responsive">
		                    <data-table :columns="columns" class="table"  :urltable="url_table"></data-table>
		        		</div>

		              </div>
		            </div>

		     	</div>
		    </div>
		 	<modal 
			:showModal="showModal"
			:key="componentKey">
				<template v-slot:header>
				    Imagen de la visita <b>{{ namemodal }}</b>
				</template>
		    	<img :src="`${srcmodal}`" alt="" class="img-fluid w-100">
		    </modal>

		    <!-- /.row (main row) -->
		</section-content>
	</div>
</template>
<script>
	import SectionContent from "@/components/SectionContent.vue"
	import HeaderTitle from "@/components/HeaderTitle.vue"
	import DataTable from '@/components/datatables/DataTableVisitas.vue';
	import { VueDatePicker } from '@mathieustan/vue-datepicker';
	import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';
	import Modal from '@/components/Modal.vue';

	import {mapGetters} from 'vuex';
	export default {
		components: {
	      SectionContent,HeaderTitle,DataTable,VueDatePicker,Modal
	    },
	    data: function() {
	    	return {
	    		url_table:route('visitas.index'),
	    		fechadesdec:null,
	    		showModal:false,
	    		componentKey:0,
	    		srcmodal:null,
	    		namemodal:null,
	    		columns:[
			        {
			        	data:'fecha',
			        },
			        {
			        	data:'nombre',
			        },
			        {
			        	data:'dni',
			        	title:'Identificacion',
			        	
			        },
			        {
			        	data:'entidad',
			        	title:'Entidad'
			        },
			        {
			        	data:'motivo',
			        	title:'Motivo'
			        },
			        {
			        	data:'empleado',
			        	title:'Empleado Publico'
			        },
			        {
			        	data:'sede',
			        	title:'Sede'
			        },
			        {
			        	data:'oficina',
			        	title:'Oficina'
			        },
			        {
			        	data:'hora_entrada',
			        },
			        {
			        	data:'hora_salida',
			        	orderable: false,
			          	searchable: false,
			          	createdCell:this.createdCellMarcar,
			        },
			      
			
			      
			        {
			        	data:'action',
			        	orderable: false,
			          	searchable: false,
			          	createdCell:this.createdCellAction,
			        },
			        {
			        	data:'actionviewimg',
			        	title:'Foto',
			        	orderable: false,
			          	searchable: false,
			          	createdCell:this.createdCellActionView,
			        }

			    ],
	    	}
	    },
	    
	    computed:{
	    	fechaDesde: {
			    // getter
			    get: function () {
			      return this.$store.getters['fechavisitas/desde']
			    },
			    // setter
			    set: function (newValue) {
			      this.$store.commit('fechavisitas/setDesde',newValue)
			      this.fechadesdec = newValue;
			    }
			},
			fechaHasta: {
			    // getter
			    get: function () {
			      return this.$store.getters['fechavisitas/hasta']
			    },
			    // setter
			    set: function (newValue) {
			      this.$store.commit('fechavisitas/setHasta',newValue)
			    }
			},
	    },
	    methods:{
		   	createdCellMarcar(cell, cellData, rowData) {
	    		let me = this;
	 			if (rowData.hora_salida == 0) {
		          	$(cell).empty();
		            let actions = Vue.extend(require('@/components/datatables/actionMarcar.vue').default);

		            let instance = new actions({
		                propsData: {
		                	id:rowData.id,
		                	url_marcar:route('visitas.marcar')
		                },
		            });
		            instance.$mount();
		        
		            $(cell).empty().append(instance.$el);
	            }
	    	},
		   	createdCellAction(cell, cellData, rowData) {
	          	$(cell).empty();
	            let actions = Vue.extend(require('@/components/datatables/actionVisitas.vue').default);

	            let instance = new actions({
	                propsData: {
	                	id:rowData.id,
	                	url_eliminar:route('visitas.delete'),
	                },
	            });
	            instance.$mount();
	            let me = this;
	        	instance.$on('edit_emit', function(event) {

	        		me.$router.push(`visitas/edit/${rowData.id}`) // -> /user

	        	})
	        	instance.$on('view', function(event) {

	        		me.$router.push(`visitas/view/${rowData.id}`) // -> /user

	        	})


	            $(cell).empty().append(instance.$el);
	            
		   	},
		   	createdCellActionView(cell, cellData, rowData) {

		   		if (rowData.actionviewimg !== '') {
			   		$(cell).empty();
		            let actions = Vue.extend(require('@/components/datatables/actionViewImg.vue').default);

		            let instance = new actions({
		                propsData: {
		                	id:rowData.id,
		                },
		            });
		            instance.$mount();
		            let me = this;
		        	instance.$on('openmodal', function(event) {
		             	me.srcmodal = `${base_path_asset}storage/Visitas/${rowData.srcfoto}`;	
		             	me.namemodal = rowData.nombre
		             	me.componentKey +=1
		             	me.showModal = true;	
		            })
		            $(cell).empty().append(instance.$el);
	            }
		   	},
	    	resetfilters(event){
	    		this.$store.commit('fechavisitas/setHasta',null)
	    		this.$store.commit('fechavisitas/setDesde',null)
	    	    $('#table_id').DataTable().draw();
	    	},
	    	tablesearch(event){
	    	   $('#table_id').DataTable().draw();
	    	}
	    }
	}
</script>