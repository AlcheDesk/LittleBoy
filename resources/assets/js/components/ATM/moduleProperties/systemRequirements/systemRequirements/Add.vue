<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="packSystemRequirementDialog = true">{{ lang.operator.new }}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.add" :visible.sync="packSystemRequirementDialog" @open="initAddEnginesDialog" :show-close="false" :append-to-body="true">
      <el-form :model="packSystemRequirement" :rules="paramValidation" ref="packSystemRequirement" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.type" prop="systemRequirements">
          <el-select v-model="packSystemRequirement.systemRequirements" value-key="name" clearable multiple size="small" filterable :placeholder="lang.dialog.placeholder.select">
            <el-option
              v-for="item in getSelectSystemRequirements"
              :key="item.label"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('packSystemRequirement')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newEngines('packSystemRequirement')">{{ lang.operator.confirm }}</el-button>
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
        packSystemRequirement: {
          systemRequirements: [],
        },
        packSystemRequirementDialog: false,
        paramValidation: {
          systemRequirements: [{required: true, type: 'array', validator: validatorParams }]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectSystemRequirements'])
    },
    methods: {
      ...mapActions(['addPackSystemRequirement', 'readSystemRequirements']),
      cancel(formname) {
        this.packSystemRequirementDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddEnginesDialog() {
        this.packSystemRequirement.systemRequirements = [];
        const obj = {
          pageNumber: 1,
          pageSize: 'all'
        };
        this.readSystemRequirements(obj);
      },
      newEngines(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const param = {
              packId: this.packId,
              data: this.packSystemRequirement.systemRequirements.map((item) => { return {id: item.id} })
            }
            this.addPackSystemRequirement(param).then((res) => {
              this.$emit('packDriverAddDone');
            }, (err) => {
              console.log(err);
            });
            this.packSystemRequirementDialog = false;
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