<template>
    <div>
        <!-- Modal -->
        <button  @click="modalopen" class="btn btn-primary btn-sm "  title="Editar"  >
            <slot><i class="fas fa-eye"></i></slot>
        </button>
     
    </div>
</template>

<script>
    export default{
        props: ['id','url_marcar'],
        methods: {
          modalopen(){
            this.$emit("openmodal");
          }
        }
        
          
    }
</script>