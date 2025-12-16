# 📈 Stock Table Plugin (Wisementt)

**Tabla de cotizaciones bursátiles en tiempo real para WordPress.**

Este plugin genera una tabla dinámica que muestra información financiera clave (Precio, Variación, Capitalización de Mercado) para una lista predefinida de empresas. Consume la API de *Financial Modeling Prep* para obtener los datos más recientes y los presenta con indicadores visuales de rendimiento (colores verde/rojo).

## 📋 Características Principales

### 📊 Datos Financieros
* **Conexión API Externa:** Itera sobre una lista de símbolos bursátiles (tickers) y realiza peticiones HTTP a la API de Financial Modeling Prep para obtener el perfil financiero de cada empresa.
* **Manejo de Errores de Conexión:** Implementa un contexto de flujo (`stream_context_create`) para manejar solicitudes HTTP, configurado para omitir la verificación SSL estricta (útil en ciertos entornos de desarrollo, aunque se recomienda precaución en producción).

### 🎨 Visualización y Estilos
* **Indicadores de Tendencia:** Utiliza lógica condicional para aplicar clases CSS (`positive-change` o `negative-change`) a los valores de variación. Si el cambio es mayor o igual a 0, se muestra en **verde**; si es negativo, en **rojo**.
* **Diseño Responsivo:** Incluye estilos CSS inyectados directamente para dar formato a la tabla (`.stock-table`), asegurando que las celdas tengan el espaciado correcto, bordes y colores de fondo para los encabezados.

### 🛠️ Configuración del Servidor
* **Tiempo de Ejecución:** Aumenta el límite de tiempo de ejecución del script (`set_time_limit(300)`) para evitar que el proceso se corte si la API tarda en responder múltiples peticiones.

## ⚙️ Configuración (Hardcoded)

Este plugin no tiene panel de administración. Los datos se configuran directamente en el código:

1.  **Lista de Empresas (Símbolos):**
    Los tickers de las acciones están definidos en un array. Para añadir o quitar empresas, edita la variable `$symbols`.
    *(Ver snippet al final).*

2.  **API Key:**
    La clave de la API está incrustada directamente en la URL de la petición dentro del bucle `foreach`.

## 📂 Estructura del Plugin

* `stock-table-plugin.php`: Archivo único que contiene:
    * Definición del Shortcode.
    * Lógica de petición HTTP (`file_get_contents`).
    * Renderizado HTML de la tabla.
    * Estilos CSS (`<style>`).

## 🚀 Instalación

1.  Sube la carpeta del plugin a `/wp-content/plugins/`.
2.  Activa el plugin desde el panel de WordPress.
3.  Usa el shortcode en cualquier página o entrada.

---
**Versión:** 1.0
**Autor:** Daniel Diaz - Tag Marketing
**Tecnología:** PHP, CSS, Financial Modeling Prep API.

### 💻 Shortcode

Copia y pega este código corto donde quieras que aparezca la tabla:

```shortcode
[stock_table]
