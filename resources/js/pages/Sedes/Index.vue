<template>
	<div>
		<section-content>
		  	<form-modal 
			:tipe="tipeform"
			:urlform="urlform"
			:tipemessage="tipemessage" 
			:form="form"
			:key="componentKey"
			:showModal="showModal"
			/>
		    <!-- Main row -->
		    <div class="row">
		    	<div class="col-12">
			     	<div class="card">
			     	   <div class="card-header bg bg-info">
			     	   		<b><i class="fas fa-building"></i> Sedes </b>
			     	   </div>
		              <div class="card-body">
	              		<button type="button" class="btn btn-primary mb-1" @click.prevent="createform">
		              	  <i class="fas fa-plus-square"></i>
						  ADD
						</button>
		                <div class="table-responsive">
		                    <data-table :columns="columns" class="table"  :urltable="url_table"></data-table>
		        		</div>

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
	import DataTable from '@/components/datatables/DataTable.vue';
	import FormModal from '@/components/sedes/Form.vue';

	export default {
		components: {
	      SectionContent,HeaderTitle,DataTable,FormModal
	    },
	    data: function() {
	    	return {
	    		url_table:route('sedes.index'),
	    		urlform:null,
	    		tipeform:null,
	    		tipemessage:null,
	    		showModal:false,
	    		componentKey:0,
	    		form:{
	    			sede:'',

	    		},
	    		columns:[
			        {
			        	data:'id',
			        },
			        {
			        	data:'sede',
			        },
			      
			        {
			        	data:'action',
			        	orderable: false,
			          	searchable: false,
			          	createdCell:this.createdCell,
			        }
			    ],
	    	}
	    },
	    
	    methods:{
		 	createform(){
             	this.form = {
             		motivo:'',
             	}
             	this.urlform = route('sedes.save')
             	this.tipeform = 'create'
             	this.tipemessage = `Crear Sede `
             	this.componentKey += 1
             	this.showModal = true
	       	},
		   	createdCell(cell, cellData, rowData) {


		          	$(cell).empty();
		            let actions = Vue.extend(require('@/components/datatables/actions.vue').default);
		            let instance = new actions({
		                propsData: {
		                	id:rowData.id,
		                	url_delete:route('sedes.delete'),
		                },
		            });
		            instance.$mount();
		            let me = this;
		        	instance.$on('edit_emit', function(event) {

		        		//me.$router.push(`visitas/edit/${rowData.id}`) // -> /user
		        		me.form = rowData
		             	me.urlform = route('sedes.update')
		             	me.tipeform = 'update'
		             	me.tipemessage = `Actualizar Sede ${rowData.id} `
		             	me.componentKey += 1
		             	me.showModal=true
		        	})
		        	


		            $(cell).empty().append(instance.$el);
	        	
	            
		   	},
	    }
	}
</script>