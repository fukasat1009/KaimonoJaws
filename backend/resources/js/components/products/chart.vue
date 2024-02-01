<script>
import { Line } from 'vue-chartjs'
export default {
	extends: Line,
	mounted () {
		this.renderChart({
			labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
			datasets: [
				{
					label: '原価',
					backgroundColor: 'rgba(60, 160, 220, 0.3)',
					borderColor: 'rgba(60, 160, 220, 0.8)',
					data: this.cost,
				},
				{
					label: '回収金額',
					backgroundColor: 'rgba(60, 190, 20, 0.3)',
					borderColor: 'rgba(60, 190, 20, 0.8)',
					data: this.price,
				},
			]
		},{
			scales: {
				yAxes: [{
					ticks: {
						suggestedMin: 0,
						suggestedMax: Math.max(...this.cost) + 50000,
						beginAtZero: true,
					}
				}]
			}
		})
	},
	data: function() {
		return {
			price: [300000, 360000, 380000, 400000, 450000, 500000, 600000],
			cost: [4000000,4000000,4000000,4000000,4000000,4000000,4000000],
		}
	},
}
</script>