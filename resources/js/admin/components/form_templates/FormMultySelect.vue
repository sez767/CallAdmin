<template>
  <div class="form-group row" id="multiselect_multy_container">
    <label :for="idName" class="col-form-label" v-html="labelText" :class="{ 'text-danger': error }"></label>
    <multiselect
      v-model="selectedData"
      :options="dataOptions"
      :placeholder="placeHolder"
      :multiple="true"
      :preserve-search="true"
      label="label"
      track-by="value"
      :showPointer="true"
      @remove="removeHandler"
      @search-change="searchHandler"
      :open-direction="direction"
      :loading="isSpin"
      :selectLabel="'Выбрать'"
      :deselectLabel="'Убрать'"
      :id="idName"
      :show-no-results="true"
      :disabled="disabledData"
      :showNoOptions="false"
    >
      <span slot="noResult" v-html="'Ничего не найдено'"/>
      <span slot="noOptions" v-html="'Введите данные'"/>
    </multiselect>
    <div class="text-danger input-error error-position" v-if="error" v-html="error"/>
  </div>
</template>
<script>
  import Multiselect from 'vue-multiselect';

  export default {
    props: [
      'labelText', 'idName', 'placeHolder', 'dataOptions', 'nameInput', 'value',
      'selected', 'direction', 'isSpin', 'disabledData', 'isRemote', 'error'
    ],
    methods: {
      removeHandler: function (removedOption) {
        let arr = this.selectedData.filter(item => item.value !== removedOption.value);
        this.selectedData = arr;
        this.$emit('update:selected', arr);
      },
      searchHandler: function (val, id) {
        if (this.isRemote) {
          this.$emit('update:inquire', val);
        }
      }
    },
    computed: {
      selectedData: {
        get: function () {
          return this.selected;
        },
        set: function (val) {
          this.$emit('update:selected', val);
        }
      }
    },
    components: {
      Multiselect
    }
  }
</script>