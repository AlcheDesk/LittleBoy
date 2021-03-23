<style lang="scss" scoped>
  .bar {
    // background-color: #ddd;
    display: inline-block;
    height: 20px;
    width: 100%;
    margin: 5px 0 0 0;
    text-align: center;
    span {
      // width: 25%;
      height: 20px;
      float: left;
      color: #fff;
    }
    .new {
      background-color: #828283;
    }
    .wip {
      background-color: #eddd5d;
    }
    .done {
      background-color: #8ec351;
    }
    .error {
      background-color: #f3413d;
    }
  }
</style>

<template>
  <div class="bar">
    <template v-if="tasks.length">
      <span class="new" :style="{width: percent[0] * 100 +'%'}" v-if="number.new">{{ number.new }}</span>
      <span class="wip" :style="{width: percent[1] * 100 +'%'}" v-if="number.wip">{{ number.wip }}</span>
      <span class="done" :style="{width: percent[2] * 100 +'%'}" v-if="number.done">{{ number.done }}</span>
      <span class="error" :style="{width: percent[3] * 100 +'%'}" v-if="number.error">{{ number.error }}</span>
    </template>
    <template v-if="!tasks.length">
      <span style="width:100%">N/A</span>
    </template>
  </div>
</template>

<script>
  export default {
    props: {
      tasks: {
        type: Array,
        default: []
      }
    },
    data() {
      return {
        number: {
          new: 0,
          wip: 0,
          done: 0,
          error: 0
        },
        percent: [],
        total: 0
      }
    },
    watch: {
      tasks(val) {
        this.calcPercent(val)
      }
    },
    created() {
      this.calcPercent(this.tasks)
    },
    methods: {
      calcPercent(val) {
        this.number = {
          new: 0,
          wip: 0,
          done: 0,
          error: 0
        }
        for (let i = 0; i < val.length; i++) {
          var task = val[i];
          if (task.status && task.status === 'NEW') {
            this.number.new += 1
          }
          if (task.status && task.status === 'WIP') {
            this.number.wip += 1
          }
          if (task.status && task.status === 'DONE') {
            this.number.done += 1
          }
          if (task.status && task.status === 'ERROR') {
            this.number.error += 1
          }
        }
        this.total = this.number.new + this.number.wip + this.number.done + this.number.error
        // console.log('total: ' + this.total + ', new:' + this.number.new + ', wip:' + this.number.wip + ', done:' + this.number.done + ', error:' + this.number.error)
        this.percent[0] = this.number.new ? this.number.new / this.total : 0
        this.percent[1] = this.number.wip ? this.number.wip / this.total : 0
        this.percent[2] = this.number.done ? this.number.done / this.total : 0
        this.percent[3] = this.number.error ? this.number.error / this.total : 0

        // 排序新数组
        var arr = this.percent.slice(0)
        arr = arr.sort(function(a, b) {
          return a - b
        })
        // 遍历percent数组，将小于0.05的补到0.05
        var gap = 0
        for (let x = 0; x < this.percent.length; x++) {
          if (this.percent[x] > 0 && this.percent[x] < 0.05) {
            gap += (0.05 - this.percent[x])
            this.percent[x] = 0.05
          }
        }
        // 将最大数值减去其他增补值
        for (let y = 0; y < this.percent.length; y++) {
          if (this.percent[y] === arr[3]) {
            this.percent[y] = this.percent[y] - gap
          }
          break
        }
        // console.log('total: ' + this.total + ', new:' + this.percent[0] + ', wip:' + this.percent[1] + ', done:' + this.percent[2] + ', error:' + this.percent[3])
      }
    }
  };
</script>


