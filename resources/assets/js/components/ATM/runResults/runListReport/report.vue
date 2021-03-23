<template>
  <div class="report_container">
    <div class="list_content">
      <div class="list_name">
        <label>{{ lang.dialog.title.list_name }}：</label>
        <span>{{reportDetails.name}}</span>
      </div>
      <div class="list_status">
        <label>{{ lang.table.status }}：</label>
        <template v-if="reportDetails.status == 'FAIL' || reportDetails.status == 'ERROR'">
         <span class="text_fail">{{reportDetails.status}}</span>
       </template>
       <template v-else-if="reportDetails.status == 'PASS'">
        <span class="text_success">{{reportDetails.status}}</span>
      </template>
      <template v-else-if="reportDetails.status == 'WIP'">
        <span class="text_wip">{{reportDetails.status}}</span>
      </template>
      <template v-else>
        <span>{{reportDetails.status}}</span>
      </template>
      </div>
    </div>
    <div class="list_content">
      <label>{{ lang.table.run_date }}：</label>
      <span>{{new Date(reportDetails.startAt).toLocaleString()}}</span>
    </div>
    <div class="list_content">
      <div class="list_status">
        <label>{{ lang.table.comment }}：</label>
      </div>
      <div class="list_comment">
        <span>{{reportDetails.comment}}</span>
      </div>
    </div>
    <template v-for="item in reportDetails.runs">
      <div class="list_content">
        <div class="list_status"></div>
        <div class="case_block">
          <div class="list_content">
            <label>{{ lang.table.testcase_name }}：</label>
            <span>{{item.name}}</span>
          </div>
          <div class="list_content">
            <label>{{ lang.table.run_date }}：</label>
            <span>{{new Date(item.startAt).toLocaleString()}}</span>
          </div>
          <div class="list_content">
            <div class="flex_4">
              <label>{{ lang.table.operating_environment }}：</label>
            </div>
            <div class="flex_15">
              <div>{{item.parameter.environment }}</div>
            </div>
          </div>
          <div class="list_content">
            <div class="flex_15">
              <label>{{ lang.dialog.title.code_info }}：</label>
            </div>
            <div style="flex: 15">
              <div>{{ item.parameter.CI}}</div>
            </div>
          </div>
          <div class="list_content">
            <div class="list_status">
              <label>{{ lang.dialog.title.step }}：</label>
            </div>
            <div class="list_comment">
              <ol>
                <template v-for="instruction in item.instructionResults">
                  <li>
                    <div>{{instruction.target}} >> {{instruction.action}} >> {{instruction.inputData}}</div>
                    <div> {{ lang.dialog.title.expected_value }}: {{instruction.expectedValue || 'N/A'}};  {{ lang.dialog.title.actual_value }}: {{instruction.returnValue || 'N/A'}}</div>
                    <div> {{ lang.table.comment }}: {{instruction.instruction.comment}}</div>
                  </li>
                </template>
              </ol>
            </div>
          </div>
          <div class="list_content">
            <div class="list_status">
              <label>{{ lang.table.status }}：</label>
            </div>
            <div class="list_comment">
              <template v-if="item.status == 'FAIL' || item.status == 'ERROR'">
                <span class="text_fail">{{item.status}}</span>
              </template>
              <template v-else-if="item.status == 'PASS'">
                <span class="text_success">{{item.status}}</span>
              </template>
              <template v-else-if="item.status == 'WIP'">
                <span class="text_wip">{{item.status}}</span>
              </template>
              <template v-else>
                <span>{{item.status}}</span>
              </template>
             </div>
          </div>
          <div class="list_content">
            <div class="list_status">
              <label>{{ lang.table.comment }}：</label>
            </div>
            <div class="list_comment">
              <span>{{item.testCase.comment}}</span>
            </div>
          </div>
          <div class="list_content">
            <div class="flex_4">
              <label>{{ lang.dialog.title.test_instruction }}：</label>
            </div>
            <div class="flex_15">
              <template v-if="item.status == 'TIMEOUT'">
                <span>{{ lang.dialog.title.timeout }}</span>
              </template>
              <template v-else>
                <span>{{item.errorMessage || lang.dialog.title.no_problem }}</span>
              </template>
            </div>
          </div>
          <template v-if="item.lastImg">
            <div class="list_content">
              <div class="list_status">
                <label>{{ lang.dialog.title.screenshot }}：</label>
              </div>
              <div class="list_comment">
                <img :src="'/' + item.lastImg.substr(4).replace(/\\/g,'/')" width="100%"/>
              </div>
            </div>
          </template>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
  import { mapGetters, mapActions } from 'vuex'

  export default {
    props: {
      lang: {
        default: {},
      },
      reportDetails: {}
    },
    data() {
      return {};
    },
  };
</script>
