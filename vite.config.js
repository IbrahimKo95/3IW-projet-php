import { defineConfig } from "vite";
import path from "path";
import FullReload from "vite-plugin-full-reload";
import VitePluginRestart from 'vite-plugin-restart';

export default defineConfig({
	build: {
		outDir: "sources/dist",
		lib: {
			entry: path.resolve(__dirname, "./sources/src/js/main.js"),
			name: "framework ESGI",
		},
	},
	plugins: [
		// Ajout des plugins
		FullReload(["./sources/src/scss/**/*.{scss,sass}"]),
		VitePluginRestart({
			restart: [
				'./sources/src/scss/**/*.scss',
			],
		}),
	],
	server: {
		watch: {
			usePolling: true,
		},
		hmr: {
			protocol: 'ws',
			host: 'localhost',
		},
	},
});
