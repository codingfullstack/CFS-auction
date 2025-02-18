import defaultConfig from "@wordpress/scripts/config/webpack.config.js";
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

// Sukuriame __dirname funkciją
const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

export default {
    ...defaultConfig,
    entry: {
        ...defaultConfig.entry(),
        "admin/index": "./src/admin",
    }, 
    output: {
        path: join(__dirname, "build"),
        filename: "[name].js", 
    },
};

