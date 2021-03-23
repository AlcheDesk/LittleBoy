<template>
  <div>
    <div class="toolbar">
      <slot name="toolbar"></slot>
    </div>
    <div class="Container">
      <slot name="container"></slot>
    </div>
  </div>
</template>

<script>
  export default {
    data () {
      return {};
    }
  };
</script>

<style>
  .toolbar {
    height: 10%;
    box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1), inset 13px 6px 27px rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.2);
    border-radius: 7px 7px 7px 7px;
  }
  .Container {
    background-color: #fcfcfc !important;
  }
</style>