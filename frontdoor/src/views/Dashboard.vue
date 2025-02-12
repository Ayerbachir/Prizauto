<template>
  <div class="test">
    <div class="header">
      <h1><b style="color:#4ade80; font-size: 35px;">D</b>ashboard</h1>
      
    </div>
    <div class="logo">
        <img src="../assets/logo.png" alt="logo">
      </div>
    <div class="charts">
      <!-- Bar Chart -->
      <div class="chart1">
        <canvas id="barchart" class="barchart"></canvas>
      </div>

      <!-- Doughnut Chart -->
      <div class="chart1">
        <canvas id="doughnutchart" class="barchart"></canvas>
        
      </div>
    </div>
    <table class="car-table">
      <thead>
        <tr>
          <th>Cars</th>
          <th>Users</th>
          <th>Reservation</th>
          <th>Car Available</th>
          <th>Earned DT</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ cars.length }}</td>
          <td>{{ users.length }}</td>
          <td>{{ filteredData.length }}</td>
          <td>{{ (cars.length)-filteredData.length }}</td>
          <td>{{ earnData }}</td>
        </tr>
      </tbody>
    </table>
    <div class="info">
		  <span class="material-icons">group </span><b class="bnav">+ 50</b><br>
		  <span class="material-icons">directions_car</span><b class="bnav">+ 22</b><br>
		  <span class="material-icons">handshake</span><b class="bnav">+ 1256</b>
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto';
import axios from 'axios'
export default {
  data() {
    return {
      cars:[],
      users:[],
      reseData:[],
      chartInstance: null,
      doughnutChartInstance: null,
    };
  },computed: {
    filteredData() {
      return this.reseData.filter((rese) => rese.state === 0);
    },
    earnData() {
    return this.reseData
      .filter((rese) => rese.state === 1)
      .reduce((total, rese) => total + rese.paid, 0);
  },
  },
  mounted() {
    this.fetchCU();
    this.fetchCars();
    this.fetchUsers();
    console.log('car tabe :',this.cars.length);

    this.initializeCharts();

    // Observe the size of the chart container
    const resizeObserver = new ResizeObserver(() => {
      if (this.chartInstance) {
        this.chartInstance.resize(); // Resize the chart on container changes
      }
      if (this.doughnutChartInstance) {
        this.doughnutChartInstance.resize();
      }
    });
    const chartContainers = document.querySelectorAll(".chart1");
    chartContainers.forEach((container) => {
      resizeObserver.observe(container);
    });
    
  },
  methods: {
    fetchCars() {
      axios.get('http://127.0.0.1:8000/api/cars')
        .then(response => {
          this.cars = response.data;
          
        })
        .catch(error => {
          console.error("There was an error fetching the car data:", error);
          
        });
    },
    fetchUsers() {
      axios.get('http://127.0.0.1:8000/api/users')
        .then(response => {
          this.users = response.data;
          
        })
        .catch(error => {
          console.error("Error fetching data:", error);
         
        });
    },
    fetchCU() {
    axios.get('http://127.0.0.1:8000/api/reservations')
      .then(response => {
        this.reseData = response.data;
      })
      .catch(error => {
        console.error("Error fetching users:", error);
      });
  },
    
    initializeCharts() {
      const barCtx = document.getElementById('barchart').getContext('2d');
      const doughnutCtx = document.getElementById('doughnutchart').getContext('2d');

      // Bar Chart
      this.chartInstance = new Chart(barCtx, {
        type: 'bar',
        data: {
          labels: ['June', 'July', 'August', 'September', 'October', 'November', 'December'],
          datasets: [
            {
              label: 'Rent 2024-2025',
              data: [15, 19, 14, 9, 5, 6,3],
              backgroundColor: [
                '#4ade80', '#1e293b', '#4ade80', '#1e293b', '#4ade80', '#1e293b', 
              ],
              borderColor: [
                '#1e293b', '#4ade80', '#1e293b', '#4ade80', '#1e293b', '#4ade80', 
              ],
              borderWidth: 2,
            },
          ],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        },
      });

      // Doughnut Chart
      this.doughnutChartInstance = new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
          labels: ['Cars', 'User', 'Reservation'],
          datasets: [{
            label: 'Doughnut Chart Example',
            data: [3, 8, 2],
            backgroundColor: ['rgb(160, 160, 160)', '#1e293b', '#4ade80'],
            borderWidth: 1,
          }],
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
        },
      });
    },
    
  },
};
</script>


<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
.bnav{
  position: relative;
  top: -4%;
}
.info {
  position: absolute;
  border-top-left-radius:20px ;
  border-bottom-left-radius:20px ;
  display:flexbox;
  right: 0%;
  top: 35%;
  width: 7%; /* Set the width to 10% */
  height: 30%; /* Set the height to 30% */
  background-color: #4ade80; /* Optional: background color */
}

.material-icons {
  font-size: 30px; 
  padding: 10px; /* Adjust space around icons */
  padding-top:25% ;
}

.info:hover{
  color: #ddd;
}

html, body {
  width: 100%;
  overflow-x: hidden;
}

.test {
  width: 100%;
  max-width: 100%;
  margin: 0 auto;
  overflow-x: hidden;
}

table {
  width: 100%;
  margin: 5%;
  table-layout: fixed;
  border-collapse: collapse;
}

.table-container {
  margin: 20px auto;
  padding: 1px;
}

.car-table {
  width: 100%;
  max-width: 100%;
  padding: 1rem;
  border-collapse: collapse;
  table-layout: auto;
}

.car-table th,
.car-table td {
  padding: 8px;
  text-align: left;
  border: 1px solid #ddd;
}

.car-table th {
  background-color: #f2f2f2;
  font-weight: bold;
}

.car-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.car-table tr:hover {
  background-color: #e2e2e2;
}

.header {
  padding: 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.logo {
  width: 5%;
}

.logo img {
  position: absolute;
  width: 4%;
  right: 0%;
  top: 2%;
  height: auto;
  animation: colorChange 6s linear infinite; 
}

.charts {
  display: flex;
  flex-wrap: wrap;
  margin-left:5% ;
  margin-top:2% ;
  gap: 15rem;
  justify-content: center;
}

.chart1 {
  flex: 1 1 calc(33.333% - 2rem); 
  max-width: 400px; 
  height: 250px;
  margin: 0 auto;
}


@keyframes colorChange {
  0% {
    filter: brightness(0) saturate(100%) invert(80%) sepia(26%) saturate(744%) hue-rotate(93deg) brightness(92%) contrast(92%);
    opacity: 1;
  }
  50% {
    filter: brightness(0) saturate(100%) invert(10%) sepia(16%) saturate(758%) hue-rotate(182deg) brightness(90%) contrast(89%);
    opacity: 1;
  }
  100% {
    filter: brightness(0) saturate(100%) invert(80%) sepia(26%) saturate(744%) hue-rotate(93deg) brightness(92%) contrast(92%);
    opacity: 1;
  }
}

</style>



