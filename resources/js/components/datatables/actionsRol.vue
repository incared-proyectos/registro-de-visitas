<template>
    <div>
      <button  @click="edit" class="btn btn-primary btn-sm"  title="Editar"  >
          <i class="fas fa-edit"></i>
      </button>
    </div>
</template>
<script>
    export default{
        methods: {
          edit(event) {
            this.$emit("edit_emit");
          },
        },
    }
</script>