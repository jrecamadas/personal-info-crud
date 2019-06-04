export default {
	methods: {
		calculatePercentage(proficiency) {
            var width = 0;
            width = (proficiency/10)*100;
            return width + "%";
        }
	}
}