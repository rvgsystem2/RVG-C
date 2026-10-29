import defaultTheme from 'tailwindcss/defaultTheme';
export default { content: ['./resources/views/component/*.blade.php','./resources/views/front/**/*.blade.php','./resources/js/premium.js'], corePlugins: { preflight: false }, theme: {extend:{colors:{ink:'#111827',paper:'#f7f6f2',victory:'#e43d35'},fontFamily:{sans:['Inter',...defaultTheme.fontFamily.sans]}}},plugins:[] };
