// import { defineConfig } from "vite";
// import laravel from "laravel-vite-plugin";

// export default defineConfig({
//     plugins: [
//         laravel({
//             input: ["resources/css/app.css", "resources/js/app.js"],
//             refresh: true,
//         }),
//     ],

//     build: {
//         manifest: true, // ✅ tells Vite to generate manifest.json
//         outDir: "public/build", // ✅ Laravel expects it here
//         assetsDir: "assets", // ✅ will output to public/build/assets
//     },

//     base: process.env.APP_ENV === "production" ? "/build/" : "/",
// });

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],

    build: {
        manifest: true,
        outDir: 'public/build',  // ✅ ensure manifest.json is here
        emptyOutDir: true,       // ✅ clears old files
    },
});
