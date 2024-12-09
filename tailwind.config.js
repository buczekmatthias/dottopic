/** @type {import('tailwindcss').Config} */
export default {
	content: ['./resources/**/*.{vue,js,ts,blade.php}'],
	theme: {
		extend: {
			minHeight: { screen: ['100vh', '100dvh'] }
		}
	},
	plugins: [],
};