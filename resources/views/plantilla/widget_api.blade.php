<!-- WIDGET SUPERIOR DE APIS EXTERNAS (GEOLOCALIZACIÓN, CLIMA Y TIPO DE CAMBIO) -->
<div class="bg-slate-900 text-white text-xs py-2 px-4 shadow-inner fixed w-full z-40 top-0 start-0 border-b border-slate-800">
    <div class="max-w-screen-xl mx-auto flex flex-wrap items-center justify-between gap-3">

        <!-- BLOQUE 1: GEOLOCALIZACIÓN POR IP (CIUDAD, ESTADO, PAÍS) -->
        <div class="flex items-center gap-2 font-medium">
            <span class="bg-red-500/20 text-red-400 p-1 rounded-md flex items-center justify-center">
                <i class="bi bi-geo-alt-fill text-sm"></i>
            </span>
            <span id="widget-geo-loading" class="text-slate-400 animate-pulse">Obteniendo ubicación IP...</span>
            <span id="widget-geo-data" class="hidden text-slate-200 font-semibold">
                <span id="widget-ciudad">--</span>, <span id="widget-estado">--</span>, <span id="widget-pais">--</span>
            </span>
        </div>

        <!-- BLOQUE 2: INFORMACIÓN METEOROLÓGICA / CLIMA (TEMPERATURA, HUMEDAD, PROB. LLUVIA) -->
        <div class="flex items-center gap-4 font-medium flex-wrap">
            <!-- TEMPERATURA -->
            <div class="flex items-center gap-1.5 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/50">
                <i class="bi bi-thermometer-half text-amber-400 text-sm"></i>
                <span id="widget-temp" class="text-amber-300 font-bold">-- °C</span>
            </div>

            <!-- HUMEDAD -->
            <div class="flex items-center gap-1.5 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/50">
                <i class="bi bi-droplet-fill text-blue-400 text-xs"></i>
                <span id="widget-humedad" class="text-blue-300 font-bold">--% Hum.</span>
            </div>

            <!-- PROBABILIDAD DE LLUVIA -->
            <div class="flex items-center gap-1.5 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/50">
                <i class="bi bi-cloud-rain-heavy-fill text-cyan-400 text-xs"></i>
                <span id="widget-lluvia" class="text-cyan-300 font-bold">--% Lluvia</span>
            </div>

            <!-- BLOQUE 3: TIPO DE CAMBIO PESO/DÓLAR (USD / MXN) -->
            <div class="flex items-center gap-1.5 bg-emerald-950/60 px-2.5 py-1 rounded-lg border border-emerald-800/50 text-emerald-300">
                <i class="bi bi-currency-dollar text-emerald-400 text-sm"></i>
                <span>USD/MXN:</span>
                <span id="widget-dolar" class="font-black text-white">$ -- MXN</span>
            </div>
        </div>

    </div>
</div>

<!-- SCRIPT DE CONSUMO DE APIS JSON Y RECORRIDO DE DATOS -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. PETICIÓN A API DE GEOLOCALIZACIÓN POR IP (ip-api / ipapi)
        fetch('http://ip-api.com/json/')
            .then(response => response.json())
            .then(geoJson => {
                // Recorrido de las claves del JSON de Geolocalización
                const ciudad = geoJson.city || 'Guadalajara';
                const estado = geoJson.regionName || 'Jalisco';
                const pais = geoJson.country || 'México';
                const lat = geoJson.lat || 20.67;
                const lon = geoJson.lon || -103.35;

                // Despliegue de ubicación en la interfaz
                document.getElementById('widget-ciudad').textContent = ciudad;
                document.getElementById('widget-estado').textContent = estado;
                document.getElementById('widget-pais').textContent = pais;

                document.getElementById('widget-geo-loading').classList.add('hidden');
                document.getElementById('widget-geo-data').classList.remove('hidden');

                // 2. PETICIÓN A API DE CLIMA (Open-Meteo) UTILIZANDO LATITUD Y LONGITUD
                return fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,precipitation_probability&timezone=auto`);
            })
            .catch(() => {
                // Fallback por defecto si hay restricciones de red
                document.getElementById('widget-ciudad').textContent = 'Guadalajara';
                document.getElementById('widget-estado').textContent = 'Jalisco';
                document.getElementById('widget-pais').textContent = 'México';
                document.getElementById('widget-geo-loading').classList.add('hidden');
                document.getElementById('widget-geo-data').classList.remove('hidden');

                return fetch(`https://api.open-meteo.com/v1/forecast?latitude=20.67&longitude=-103.35&current=temperature_2m,relative_humidity_2m,precipitation_probability&timezone=auto`);
            })
            .then(response => response.json())
            .then(climaJson => {
                // Recorrido de los campos del JSON de Clima
                if (climaJson && climaJson.current) {
                    const temp = climaJson.current.temperature_2m;
                    const humedad = climaJson.current.relative_humidity_2m;
                    const probLluvia = climaJson.current.precipitation_probability ?? 0;

                    document.getElementById('widget-temp').textContent = `${temp} °C`;
                    document.getElementById('widget-humedad').textContent = `${humedad}% Hum.`;
                    document.getElementById('widget-lluvia').textContent = `${probLluvia}% Lluvia`;
                }
            })
            .catch(err => console.error("Error al obtener clima:", err));

        // 3. PETICIÓN A API DE TIPO DE CAMBIO PESO / DÓLAR (USD to MXN)
        fetch('https://open.er-api.com/v6/latest/USD')
            .then(response => response.json())
            .then(divisasJson => {
                // Recorrido de las tasas en el JSON de Divisas
                if (divisasJson && divisasJson.rates && divisasJson.rates.MXN) {
                    const tasaMxn = divisasJson.rates.MXN.toFixed(2);
                    document.getElementById('widget-dolar').textContent = `$${tasaMxn} MXN`;
                }
            })
            .catch(err => console.error("Error al obtener tipo de cambio:", err));
    });
</script>
