<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="packsEnginesDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="packsEnginesDialog" @open="initAddEnginesDialog" :show-close="false" :append-to-body="true">
      <el-form :model="packsEngines" :rules="paramValidation" ref="packsEngines" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.type" prop="engines">
          <el-select v-model="packsEngines.engines" value-key="name" clearable multiple size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectEngines"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('packsEngines')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newEngines('packsEngines')">{{ lang.operator.confirm }}</el-button>
      </div>
    </el-dialog>

  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: {
      lang: {
        default: {},
      },
    },
    data() {
      var validatorParams = (rule, value, callback) => {
        if (rule.required && !value.length) {
          return callback(new Error(this.lang.validator.name.required));
        } else {
          return callback();
        }
      };
      return {
        packId: null,
        packsEngines: {
          engines: [],
        },
        packsEnginesDialog: false,
        paramValidation: {
          engines: [{required: true, type: 'array', validator: validatorParams }]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectEngines'])
    },
    methods: {
      ...mapActions(['addPacksEngines', 'readEngines']),
      cancel(formname) {
        this.packsEnginesDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddEnginesDialog() {
        this.packsEngines.engines = [];
        const obj = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readEngines(obj);
      },
      newEngines(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const param = {
              packId: this.packId,
              data: this.packsEngines.engines.map((item) => { return {id: item.id} })
            }
            this.addPacksEngines(param).then((res) => {
              this.$emit('packDriverAddDone');
            }, (err) => {
              console.log(err);
            });
            this.packsEnginesDialog = false;
          } else {
            return false;
          }
        });
      },
    },
    mounted() {
      this.packId = window.location.pathname.split('/')[4];
    }
  };
</script>