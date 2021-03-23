<template>
  <div class="component_button">
    <el-button class="button_text_table" @click="showUpdateRunContainerDialog">{{lang.operator.edit}}</el-button>

    <el-dialog :close-on-click-modal="false" :title="lang.dialog.title.edit" :visible.sync="updateRunContainerDialog" :show-close="false" :append-to-body="true">
      <el-form :model="updateRunContainerData" :rules="paramValidationUpdate" ref="updateRunContainerData" label-width="100px" label-position="right" label-suffix=":">
        <el-form-item :label="lang.table.name" prop="name">
          <el-input  :placeholder="lang.dialog.placeholder.enter_name" @keyup.enter.native="editRunContainer('updateRunContainerData')" size="small" v-model.trim="updateRunContainerData.name"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.priority" prop="priority">
          <el-input type="number" size="small" v-model.trim="updateRunContainerData.priority"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.comment" prop="comment">
          <el-input type="textarea" :rows="2" :placeholder="lang.dialog.placeholder.enter_comment" v-model.trim="updateRunContainerData.comment"></el-input>
        </el-form-item>
        <el-form-item :label="lang.table.alias">
          <el-select v-model="updateRunContainerData.tags" :multiple-limit="10" clearable multiple required filterable value-key="name" size="small" :placeholder="lang.dialog.title.select_alias">
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
            v-for="tag in updateRunContainerData.tags">
            {{tag.name ? tag.name : tag}}
          </el-tag>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="cancel('updateRunContainerData')">{{ lang.operator.cancel }}</el-button>
        <el-button type="primary" @click="editRunContainer('updateRunContainerData')">{{ lang.operator.confirm }}</el-button>
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
      row: {
        default: {},
      }
    },
    data() {
      var validatorRunContainerNameUpdate = (rule, value, callback) => {
        const obj = {
          name: value,
        };
        if (!value) {
          return callback(new Error(this.lang.validator.name.required));
        }
        if (/^[\u4E00-\u9FA50-9a-zA-Z_-]{1,32}$/.test(value.replace(/(^\s+)|(\s+$)/g, ''))) {
          if (this.updatePrevName && value != this.updatePrevName) {
            this.validateRunContainerName(obj).then((res) => {
              if (parseInt(res.metadata.count) === 0) {
                return callback();
              } else {
                return callback(new Error(this.lang.validator.name.exist));
              }
            }, (err) => {
              console.log(err);
            });
          } else {
            return callback();
          }
        } else {
          return callback(new Error(this.lang.validator.name.consists));
        }
      };
      return {
        updatePrevName: '',
        updateRunContainerDialog: false,
        updateAlias: [],
        updateRunContainerData: {
          id: null,
          name: '',
          priority: null,
          comment: '',
          tags: []
        },
        paramValidationUpdate: {
          name: [{required: true, validator: validatorRunContainerNameUpdate, trigger: 'blur'}]
        },
      };
    },
    computed: {
      ...mapGetters(['getSelectRunListAlias']),
    },
    methods: {
      ...mapActions(['updateRunContainer', 'validateRunContainerName', 'setRunListLinkAlias', 'removeRunListLinkAlias', 'readRunListAlias', 'getRunListLinkAlias']),
      cancel(formname) {
        this.updateRunContainerDialog = false;
        this.$refs[formname].resetFields();
      },
      showUpdateRunContainerDialog() {
        this.updatePrevName = this.row.name;
        this.updateRunContainerData.id = this.row.id;
        this.updateRunContainerData.name = this.row.name;
        this.updateRunContainerData.comment = this.row.comment;
        this.updateRunContainerData.priority = this.row.priority;
        let obj = {
          runSetId: this.updateRunContainerData.id
        }
        this.getRunListLinkAlias(obj).then((res) => {
          this.updateRunContainerData.tags = res.data;
          this.updateAlias = res.data.map(tag => { return tag.id });
          this.updateRunContainerDialog = true;
        })
        this.readRunListAlias();
      },
      editRunContainer(formname) {
        this.$refs[formname].validate((valid) => {
          if (valid) {
            const obj = {
              id: this.updateRunContainerData.id,
              name: this.updateRunContainerData.name,
              priority: this.updateRunContainerData.priority,
              comment: this.updateRunContainerData.comment
            };
            const tags = this.updateRunContainerData.tags.map(tag => { return { id: tag.id } });
            this.updateRunContainer([obj]).then((res) => {
              if (this.updateAlias.length) {
                const param = {
                  runSetId: this.updateRunContainerData.id
                };
                param.data = this.updateAlias.join(',');
                this.removeRunListLinkAlias(param).then((res) => {
                  if (tags.length) {
                    const obj = {
                      runSetId: this.updateRunContainerData.id
                    };
                    obj.data = tags;
                    this.setRunListLinkAlias(obj).then((res) => {
                      this.$emit('runListEditDone');
                    })
                  } else {
                    this.$emit('runListEditDone');
                  }
                })
              } else {
                if (tags.length) {
                  const obj = {
                    runSetId: this.updateRunContainerData.id
                  };
                  obj.data = tags;
                  this.setRunListLinkAlias(obj).then((res) => {
                    this.$emit('runListEditDone');
                  })
                } else {
                  this.$emit('runListEditDone');
                }
              }
            }, (err) => {
              console.log(err);
            });
            this.updateRunContainerDialog = false;
          } else {
            return false;
          }
        });
      },
    }
  };
</script>
