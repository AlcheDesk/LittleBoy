<template>
  <div>
    <project-tool-bar :messageInfo="projectResultMessage">
      <div slot="breadcrumb">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item>
            <a href='/atm/RunResult/Project/?page=1+25'>{{ lang.breadcrumb.project_result }}</a>
          </el-breadcrumb-item>
          <el-breadcrumb-item>{{ lang.breadcrumb.project_global_result }}</el-breadcrumb-item>
        </el-breadcrumb>
      </div>
      <div slot="operation">
        <el-button class="button_text_table el_button_summary_result" @click="NavigationToTestCaseResults">{{ lang.operator.summary_result }}</el-button>
      </div>
    </project-tool-bar>

    <el-row style="padding: 15px;" :gutter="20">
      <el-col :span="8">
        <div id="projectChartId" class="chart_block"></div>
      </el-col>
      <el-col :span="8">
        <div id="projectChangeRateDoughnutChartId" class="chart_block"></div>
      </el-col>
      <el-col :span="8">
        <div id="projectChangeRateLineChartId" class="chart_block"></div>
      </el-col>
    </el-row>
    <el-row :gutter="40" class="row_style">
      <el-col :span="4" >
        <div @click="NavigationToProjectTestCase" :title="lang.dialog.title.navigator_testcase">
          <div class="div_text">{{ lang.dialog.title.total_number_testcase }}</div>
          <div class="div_number" style="text-decoration: underline;">{{ charts.activeTestCaseNumber }}</div>
        </div>
      </el-col>
      <el-col :span="4">
        <div @click="NavigationToTestCaseResults" :title="lang.dialog.title.navigator_testcase_result">
          <div class="div_text">{{ lang.dialog.title.running_total }}</div>
          <div class="div_number" style="text-decoration: underline;">{{ charts.totalRunNumber }} Times</div>
        </div>
      </el-col>
      <el-col :span="4">
        <div>
          <div class="div_text">{{ lang.dialog.title.project_establishment_time }}</div>
          <div class="div_number">{{ charts.duration }} Days</div>
        </div>
      </el-col>
      <el-col :span="4">
        <div>
          <div class="div_text">{{ lang.dialog.title.testcase_run_time }}</div>
          <div class="div_number">{{ charts.totalExecutionTimeInMins }} Miuntes</div>
        </div>
      </el-col>
      <el-col :span="4">
        <div>
          <div class="div_text fail_css">{{ lang.dialog.title.found_problem }}</div>
          <div class="div_number">{{ charts.failedTestCaseNumber }}</div>
        </div>
      </el-col>
      <el-col :span="4">
        <div>
          <div class="div_text pass_css">{{ lang.dialog.title.problem_fix }}</div>
          <div class="div_number">{{ charts.passRate*100 }}%</div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import echarts from 'echarts';
  import {mapGetters, mapActions} from 'vuex'

  export default {
    props: ['message'],
    data() {
      return {
        permissionRule: {},
        lang: {},
        projectId: null,
        projectChart: null,
        projectChangeRateDoughnutChart: null,
        projectChangeRateLineChart: null,
        projectResultMessage: {},
        charts: {},
        areaChart: {
          date: [],
          data: []
        },
        doughnutCharts: {},
        lineCharts: {
          date: [],
          passed: [],
          failed: [],
          other: []
        }
      }
    },
    computed: {
      ...mapGetters(['getRunResultProjectsChart'])
    },
    watch: {
      getRunResultProjectsChart: function() {
        this.charts = this.getRunResultProjectsChart.data[0];
        var data = this.charts.runByDateChartData || [];
        var last = data.length - 1;
        this.doughnutCharts.passedTestCaseNumber = this.charts.passedTestCaseNumber;
        this.doughnutCharts.totalTestCaseNumber = this.charts.totalTestCaseNumber;
        this.doughnutCharts.failedTestCaseNumber = this.charts.failedTestCaseNumber;
        for (var i = 0; i < data.length; i++) {
          this.areaChart.date.push(data[i].executionDate);
            this.areaChart.data.push(data[i].totalNumber);
            this.lineCharts.date.push(data[i].executionDate);
            this.lineCharts.passed.push(data[i].passNumber);
            this.lineCharts.failed.push(data[i].failNumber);
            var normal = data[i].totalNumber - (data[i].failNumber + data[i].passNumber);
            this.lineCharts.other.push(normal);
        }
        this.initProjectChart();
        this.initProjectDoughnutChart();
        this.initProjectLineChart();
      }
    },
    methods: {
      ...mapActions(['readRunResultProjectCharts', 'readProjectResultForMessage']),
      initProjectChart() {
        var option = {
          tooltip: {
            trigger: 'axis',
            position: function (pt) {
              return [pt[0], '10%'];
            }
          },
          title: {
            text: this.lang.dialog.title.project_area_chart,
            bottom: 0
          },
          legend: {
            data:[this.lang.dialog.title.run_number]
          },
          xAxis: {
            type: 'category',
            boundaryGap: false,
            data: this.areaChart.date
          },
          yAxis: {
            type: 'value',
            boundaryGap: [0, '100%']
          },
          grid: {
            left: '3%',
            right: '2%',
            bottom: '15%',
            containLabel: true
          },
          series: [{
            name: this.lang.dialog.title.run_number,
            type:'line',
            smooth:true,
            symbol: 'none',
            sampling: 'average',
            itemStyle: {
              normal: {
                color: 'rgb(255, 70, 131)'
              }
            },
            areaStyle: {
              normal: {
                color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                  offset: 0,
                  color: 'rgb(255, 158, 68)'
                }, {
                  offset: 1,
                  color: 'rgb(255, 70, 131)'
                }])
              }
            },
            data: this.areaChart.data
          }]
        };

        this.projectChart = echarts.init(document.getElementById('projectChartId'));

        this.projectChart.setOption(option);
      },
      initProjectDoughnutChart() {
        var option = {
          title: {
            text: this.lang.dialog.title.run_result,
            bottom: 0
          },
          tooltip: {
            trigger: 'item',
            formatter: '{b}: {c} ({d}%)'
          },
          legend: {
            orient: 'vertical',
            left: 'left',
            data:['Failed', 'Passed', 'Other']
          },
          series: [{
            name:'',
            type:'pie',
            radius: ['50%', '70%'],
            center: ['50%', '60%'],
            avoidLabelOverlap: false,
            label: {
              normal: {
                show: false,
                position: 'center'
              },
              emphasis: {
                show: true,
                textStyle: {
                  fontSize: '10',
                  fontWeight: 'bold'
                }
              }
            },
            labelLine: {
              normal: {
                show: false
              }
            },
            data:[
            {value:this.doughnutCharts.failedTestCaseNumber, name:'Failed'},
            {value:this.doughnutCharts.totalTestCaseNumber - (this.doughnutCharts.failedTestCaseNumber + this.doughnutCharts.passedTestCaseNumber), name: 'Other'},
            {value:this.doughnutCharts.passedTestCaseNumber, name:'Passed'}
            ]
          }]
        };
        this.projectChart = echarts.init(document.getElementById('projectChangeRateDoughnutChartId'));

        this.projectChart.setOption(option);
      },
      initProjectLineChart() {
        var option = {
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            data: ['Passed', 'Failed', 'Other']
          },
          title: {
            bottom: 0,
            text: this.lang.dialog.title.project_change,
          },
          xAxis: {
            type: 'category',
            boundaryGap: false,
            data: this.lineCharts.date
          },
          yAxis: {
            type: 'value',
            boundaryGap: [0, '100%']
          },
          grid: {
            left: '3%',
            right: '2%',
            bottom: '15%',
            containLabel: true
          },
          series: [{
            name:'Failed',
            type:'line',
            data: this.lineCharts.failed
          }, {
            name:'Other',
            type:'line',
            data: this.lineCharts.other
          }, {
            name:'Passed',
            type:'line',
            data: this.lineCharts.passed
          }]
        };

        this.projectChangeRateLineChart = echarts.init(document.getElementById('projectChangeRateLineChartId'));
        this.projectChangeRateLineChart.setOption(option);
      },
      NavigationToTestCaseResults() {
        window.location.href = '/atm/RunResult/Project/' + this.projectId + '/TestCase?page=1+25';
      },
      NavigationToProjectTestCase() {
        window.location.href = '/atm/TestSetting/Project/' + this.projectId + '/TestCase?page=1+25';
      }
    },
    created() {
      var message =  JSON.parse(this.message);
      this.permissionRule = message.permissions;
      this.lang = message.lang;
      this.projectId = window.location.pathname.split('/')[4];
      const obj = {
        projectId: this.projectId
      };
      this.readRunResultProjectCharts(obj);
      const project = {
        id: this.projectId
      };
      this.readProjectResultForMessage(project).then((res) => {
        this.projectResultMessage = res.data[0];
      }, (err) => {
        console.log(err);
      })
    }
  };
</script>


