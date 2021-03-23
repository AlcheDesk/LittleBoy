<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="newRunContainerDialog = true">{{lang.operator.new}}</el-button>

    <el-dialog :title="lang.dialog.title.add" :close-on-click-modal="false" :visible.sync="newRunContainerDialog" @open="initAddRunContainerDialog" :show-close="false" :append-to-body="true">
      <el-form :model="runContainer" :rules="paramValidation" ref="runContainer" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input  :placeholder="lang.dialog.placeholder.enter_name" size="small" v-model.trim="runContainer.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.priority" prop="priority">
          <el-input  :placeholder="lang.dialog.placeholder.enter" :min="0" size="small" type="number" v-model.trim="runContainer.priority"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="runContainer.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.alias">
          <el-select v-model="runContainer.tags" :multiple-limit="10" clearable multiple required filterable value-key="name" size="small" :placeholder="lang.dialog.title.select_alias">
            <el-option 
              v-for="obj in getSelectRunListAlias"
              :key="obj.label + obj.value.id"
              :label="obj.label"
              :value="obj.value">
            </el-option>
          </el-select>
          <el-tag
            :key="tag.name ? tag.name : tag"
            size="small"
            style="margin-right: 8px;"
            v-for="tag in runContainer.tags">
            {{tag.name ? tag.name : tag}}
          </el-tag>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('runContainer')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="newRunContainer('runContainer')">{{ lang.operator.confirm }}</el-button>
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
      var validatorRunContainerName = (rule, value, callback) => {
        const obj = {
          name: value
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          this.validateRunContainerName(obj).then((res) => {
            if (parseInt(res.metadata.count) === 0) {
              return callback();
            } else {
              return callback(new Error(this.lang.validator.name.exist));
            }
          }, (err) => {
            console.log(err)
          });
        } else {
          return callback(new Error(this.lang.validator.name.consists));
        }
      };
      return {
        runContainer: {
          name: '',
          priority: null,
          comment: '',
          tags: []
        },
        newRunContainerDialog: false,
        paramValidation: {
          name: [{required: true, validator: validatorRunContainerName, trigger: 'blur'}]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectRunListAlias']),
    },
    methods: {
      ...mapActions(['addRunContainer', 'validateRunContainerName', 'readRunListAlias', 'setRunListLinkAlias']),
      cancel(formname) {
        this.newRunContainerDialog = false;
        this.$refs[formname].resetFields();
      },
      initAddRunContainerDialog() {
        this.runContainer.name = '';
        this.runContainer.priority = null;
        this.runContainer.comment = '';
        this.runContainer.tags = [];
        this.readRunListAlias();
      },
      newRunContainer(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              name: this.runContainer.name,
              priority: this.runContainer.priority,
              comment: this.runContainer.comment
            };
            const tags = this.runContainer.tags;
            this.addRunContainer([obj]).then((res) => {
              const param = {
                runSetId: res.data[0].id
              }
              if (tags.length) {
                param.data = tags.map(tag => { return { id: tag.id } });
                this.setRunListLinkAlias(param).then((res) => {
                  this.$emit('runListAddDone');
                })
              } else {
                this.$emit('runListAddDone');
              }
            }, (err) => {
              console.log(err);
            });
            this.newRunContainerDialog = false;
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
