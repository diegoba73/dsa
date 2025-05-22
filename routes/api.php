<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/lab/muestras/{id}/ensayos', 'MuestraController@getEnsayos');

/* oraculo */

Route::post('/consulta-ia', function (Request $request) {
    $pregunta = trim($request->input('pregunta'));

    if (empty($pregunta)) {
        return response()->json(['error' => 'Por favor ingrese una pregunta válida.'], 400);
    }

    /* GEMINI */
    $apiBaseUrl = config('services.google_ai.api_url'); 
    $apiKey = config('services.google_ai.api_key');
    $apiUrl = "{$apiBaseUrl}?key={$apiKey}";

    // Retrieve Deepseek API configuration from services.php
/*     $apiUrl = config('services.deepseek.api_url');
    Log::info("Using API URL: " . $apiUrl);
    $apiKey = config('services.deepseek.api_key');
    Log::info("API Key: " . (empty($apiKey) ? 'EMPTY' : 'Loaded')); */

    $client = new Client();

    $payload = [
        "contents" => [
            ["parts" => [[
                "text" => <<<EOT
                Tu tarea es interpretar preguntas en lenguaje natural y generar una consulta SQL válida para MySQL que obtenga los datos solicitados.
                    La consulta debe ser:
                    - **Sintácticamente correcta**
                    - Basada solo en las tablas y columnas permitidas
                    - Terminada con punto y coma `;`
                    - Incluye una breve explicación técnica de qué hace la consulta

                    🧠 Las preguntas pueden estar en lenguaje natural, por ejemplo:
                    - ¿Cuántas muestras se analizaron para Escherichia coli en 2024?
                    - Mostrar los resultados de ensayos de agua con valores mayores a 100.
                    - ¿Cuántos productos están registrados por empresa?
                    - Comparar la cantidad de muestras entre los ensayos X y Y este año.
                    - Listar los insumos con stock bajo en microbiología.

                    ⚠️ Regla obligatoria:
                    - No inventes nombres de columnas ni tablas. Solo usá las disponibles (ver abajo).
                    - Si la pregunta menciona un valor numérico en `resultado`, usá `CAST(resultado AS DECIMAL(10,2)) * 1` para comparar correctamente.
                    - Si la pregunta incluye `>`, `<`, o valores como `>100`, tratá esos símbolos como operadores reales en SQL.

                    📌 Tablas permitidas:
                    - analitos: `id`, `analito`, `valor_hallado`, `unidad`, `observaciones`, `parametro_calidad`, `muestra_id`
                    - articulos: `id`, `item`, `cantidad`, `cantidad_entregada`, `precio`, `pedido_id`
                    - cepas: `id`, `microorganismo_id`, `lote`, `fecha_incubacion`, `tsi`, `citrato`, `lia`, `urea`, `sim`, `esculina`, `hemolisis`, `tumbling`, `fluorescencia`, `coagulasa`, `oxidasa`, `catalasa`, `gram`, `observaciones`, `codigo_barra`, `user_id`, `created_at`, `updated_at`
                    - dbarchivos: `id`, `caja`, `establecimiento`, `descripcion`, `user_id`
                    - dbbajas: `id`, `numero`, `caja`, `fecha_baja`, `motivo`, `expediente`, `nro_registro`, `establecimiento`, `solicito`, `created_at`, `updated_at`, `user_id`
                    - dbcategorias: `id`, `categoria`, `dbrubro_id`
                    - dbdts: `id`, `nombre`, `dni`, `titulo`, `domicilio`, `ciudad`, `telefono`, `email`, `universidad`, `matricula`, `fecha_inscripcion`, `fecha_reinscripcion`, `fecha_baja`, `motivo_baja`, `ruta_dni`, `ruta_titulo`, `ruta_cv`, `ruta_cert_domicilio`, `ruta_antecedentes`, `ruta_arancel`, `ruta_vinculacion`, `ruta_foto`, `created_at`, `updated_at`
                    - dbempresas: `id`, `cuit`, `empresa`, `domicilio`, `ciudad`, `provincia`, `telefono`, `email`, `created_at`, `updated_at`, `ruta_cuit`, `ruta_dni`, `ruta_estatuto`, `baja_id`, `user_id`
                    - dbenvases: `id`, `tipo_envase`, `material`, `contenido_neto`, `contenido_escurrido`, `lapso_aptitud`, `condiciones_conservacion`, `ruta_cert_envase`, `dbrpadb_id`, `created_at`, `updated_at`
                    - dbexps: `id`, `numero`, `fecha`, `descripcion`, `user_id`
                    - dbhistorials: `id`, `area`, `motivo`, `fecha`, `estado`, `observaciones`, `created_at`, `updated_at`, `dbredb_id`, `dbrpadb_id`, `dbempresa_id`, `user_id`, `dbtramite_id`
                    - dbinspeccions: `id`, `fecha`, `establecimiento`, `direccion`, `rubro`, `motivo`, `detalle`, `higiene`, `created_at`, `updated_at`, `user_id`, `localidad_id`, `dbredb_id`
                    - dbnotas: `id`, `numero`, `fecha`, `descripcion`, `user_id`
                    - dbredbs: `id`, `numero`, `establecimiento`, `domicilio`, `fecha_inscripcion`, `fecha_baja`, `fecha_reinscripcion`, `fecha_modificacion`, `ruta_analisis`, `ruta_memoria`, `ruta_contrato`, `ruta_habilitacion`, `ruta_plano`, `ruta_acta`, `ruta_pago`, `ruta_vinculaciondt`, `finalizado`, `expediente`, `transito`, `created_at`, `updated_at`, `user_id`, `dbdt_id`, `dbempresa_id`, `dbbaja_id`, `localidad_id`
                    - dbredb_dbrubro: `id`, `dbredb_id`, `dbcategoria_id`, `dbrubro_id`, `actividad`
                    - dbremitos: `id`, `fecha`, `conclusion`, `nro_nota`, `chequeado`, `user_id`, `remitente_id`
                    - dbremito_muestra: `id`, `dbremito_id`, `muestra_id`
                    - dbrpadbs: `id`, `numero`, `denominacion`, `nombre_fantasia`, `marca`, `fecha_inscripcion`, `articulo_caa`, `fecha_reinscripcion`, `fecha_modificacion`, `fecha_baja`, `ruta_analisis`, `ruta_ingredientes`, `ruta_especificaciones`, `ruta_monografia`, `ruta_infonut`, `ruta_rotulo`, `ruta_certenvase`, `ruta_pago`, `dbbaja_id`, `iniciado`, `finalizado`, `expediente`, `created_at`, `updated_at`, `dbredb_id`, `dbempresa_id`, `user_id`, `dbredb_dbrubro_id`
                    - dbrubros: `id`, `numero`, `rubro`
                    - dbtramites: `id`, `fecha_inicio`, `tipo_tramite`, `estado`, `area`, `observaciones`, `finalizado`, `created_at`, `updated_at`, `dbempresa_id`, `dbredb_id`, `factura_id`, `dbrpadb_id`
                    - departamentos: `id`, `departamento`
                    - dlnotas: `id`, `numero`, `fecha`, `descripcion`, `user_id`
                    - dsaexpedientes: `id`, `nro_nota`, `nro_expediente`, `descripcion`, `fecha_expediente`, `estado`, `observaciones`, `costo_total`, `users_id`, `created_at`, `updated_at`
                    - dsanotas: `id`, `numero`, `fecha`, `descripcion`, `user_id`
                    - dsbnotas: `id`, `numero`, `fecha`, `descripcion`, `user_id`
                    - dsbremitos: `id`, `fecha`, `conclusion`, `nro_nota`, `chequeado`, `remitente_id`, `user_id`
                    - dsbremito_muestra: `id`, `dsbremito_id`, `muestra_id`
                    - dsonotas: `id`, `numero`, `fecha`, `descripcion`, `user_id`
                    - dsoremitos: `id`, `fecha`, `conclusion`, `nro_nota`, `chequeado`, `fecha_salida`, `remitente_id`, `user_id`
                    - dsoremito_muestra: `id`, `dsoremito_id`, `muestra_id`
                    - ensayos: `id`, `codigo`, `tipo_ensayo`, `ensayo`, `metodo`, `norma_procedimiento`, `unidades`, `valor_referencia`, `limite_d`, `limite_c`, `costo`, `activo`, `matriz_id`
                    - ensayos_old: `id`, `codigo`, `tipo_ensayo`, `ensayo`, `metodo`, `norma_procedimiento`, `unidades`, `valor_referencia`, `limite_d`, `limite_c`, `costo`, `activo`, `matriz_id`
                    - ensayo_muestra: `id`, `fecha_inicio`, `fecha_fin`, `resultado`, `ensayo_id`, `muestra_id`
                    - facturacions: `id`, `fecha_emision`, `depositante`, `detalle`, `importe`, `departamento`, `fecha_pago`, `codigo_barra`, `user_id`
                    - facturas: `id`, `remitentes_id`, `fecha_emision`, `fecha_vencimiento`, `estado`, `total`, `muestra`, `fecha_pago`, `nombre`, `ruta`, `created_at`, `updated_at`, `users_id`, `departamento_id`
                    - factura_nomenclador: `factura_id`, `nomenclador_id`, `cantidad`, `subtotal`
                    - frases: `frase`
                    - insumos: `id`, `codigo`, `nombre`, `descripcion`, `cromatografia`, `quimica_al`, `quimica_ag`, `ensayo_biologico`, `microbiologia`, `costo`, `fecha_cotizacion`, `proveedor_cotizo`
                    - insumo_pedido: `id`, `insumo_id`, `pedido_id`, `cantidad_pedida`, `cantidad_entregada`, `observaciones`, `aceptado`
                    - localidads: `id`, `codigo_postal`, `localidad`, `provincia_id`, `zona`
                    - matrizs: `id`, `matriz`
                    - mesaentradas: `id`, `departamento_id`, `fecha_ingreso`, `descripcion`, `destino`, `nro_nota_remitida`, `nro_nota_respuesta`, `usuario`, `finalizado`
                    - microorganismos: `id`, `numero`, `microorganismo`, `medio_cultivo`, `condiciones`, `tsi`, `citrato`, `lia`, `urea`, `sim`, `esculina`, `hemolisis`, `tumbling`, `fluorescencia`, `coagulasa`, `oxidasa`, `catalasa`, `gram`, `observaciones`, `proveedor_id`
                    - migrations: `id`, `migration`, `batch`
                    - modulos: `id`, `valor`, `fecha`, `coeficiente`
                    - muestras: `id`, `departamento_id`, `numero`, `tipo_prestacion`, `entrada`, `nro_cert_cadena_custodia`, `matriz_id`, `tipomuestra_id`, `muestra`, `identificacion`, `solicitante`, `remitente_id`, `fecha_entrada`, `realizo_muestreo`, `lugar_extraccion`, `fecha_extraccion`, `hora_extraccion`, `provincia_id`, `localidad_id`, `conservacion`, `cloro_residual`, `elaborado_por`, `domicilio`, `marca`, `tipo_envase`, `cantidad`, `peso_volumen`, `fecha_elaborado`, `fecha_vencimiento`, `registro_establecimiento`, `registro_producto`, `lote`, `partida`, `destino`, `microbiologia`, `quimica`, `cromatografia`, `ensayo_biologico`, `aceptada`, `criterio_rechazo`, `fecha_recepcion_analista`, `fecha_inicio_analisis`, `fecha_fin_analisis`, `observaciones`, `condicion`, `cargada`, `reviso`, `revisada`, `traducida`, `fecha_salida`, `remitir`, `codigo_barra`, `user_id`, `created_at`, `updated_at`, `factura_id`
                    - nomencladors: `id`, `descripcion`, `valor`, `departamento_id`
                    - nomencladors_old: `id`, `descripcion`, `valor`, `departamento_id`
                    - password_resets: `email`, `token`, `created_at`
                    - pedidos: `id`, `nro_pedido`, `fecha_pedido`, `descripcion`, `estado`, `fecha_expediente`, `nro_nota`, `nro_expediente`, `finalizado`, `baja`, `entrega_parcial`, `observaciones`, `costo_total`, `user_id`, `departamento_id`, `dsaexpediente_id`
                    - pedido_reactivo: `id`, `reactivo_id`, `pedido_id`, `cantidad_pedida`, `cantidad_entregada`, `costo_total`, `observaciones`, `aceptado`
                    - proveedors: `id`, `empresa`, `contacto`, `direccion`, `telefono`, `email`, `tipo_insumo`, `criticidad`
                    - provincias: `id`, `provincia`
                    - reactivos: `id`, `codigo`, `nombre`, `descripcion`, `numero_cas`, `ensayo`, `cromatografia`, `quimica`, `ensayo_biologico`, `microbiologia`, `renpre`, `costo`, `fecha_cotizacion`, `proveedor_cotizo`
                    - remitentes: `id`, `nombre`, `cuit`, `responsable`, `area`, `email`, `direccion`, `telefono`, `localidad_id`, `user_id`
                    - roles: `id`, `name`, `description`, `created_at`, `updated_at`
                    - stockinsumos: `id`, `registro`, `fecha_entrada`, `fecha_baja`, `cantidad`, `marca`, `almacenamiento`, `certificado`, `observaciones`, `codigo_barra`, `pedido`, `proveedor_id`, `insumo_id`, `area`
                    - stockreactivos: `id`, `registro`, `fecha_entrada`, `fecha_apertura`, `fecha_vencimiento`, `fecha_baja`, `contenido`, `marca`, `grado`, `lote`, `conservacion`, `almacenamiento`, `hs`, `observaciones`, `codigo_barra`, `pedido`, `proveedor_id`, `reactivo_id`, `area`
                    - tipomuestras: `id`, `tipo_muestra`, `matriz_id`
                    - users: `id`, `usuario`, `email`, `password`, `role_id`, `departamento_id`, `activo`, `remember_token`, `created_at`, `updated_at`
    
                    📌 **Uso de Tablas**:
                    - `muestras`: Contiene información sobre cada muestra.
                    - `ensayos`: Contiene información sobre los ensayos disponibles.
                    - `ensayo_muestra`: Relaciona las muestras con los ensayos y contiene los resultados de los ensayos.
                    - `tipomuestras`: Contiene información sobre los tipos de muestras.
        
                    🔹 **Reglas Condicionales**:
                    - Si la pregunta menciona **muestras**, usa la tabla `muestras`.
                    - Si la pregunta menciona **ensayos**, usa la tabla `ensayos`.
                    - Si la pregunta menciona **relación entre ensayos y muestras**, usa `ensayo_muestra` si se mencionan columnas de esta tabla (`resultado`, `fecha_inicio`, etc.).
                    - Si se pide resultados **para un año específico**, usa `fecha_entrada` en `muestras` con `YEAR(muestras.fecha_entrada) = {año}`.
                    - Si se mencionan **ensayos por su nombre**, busca en `ensayos.ensayo`.
                    - Si se mencionan **resultados numéricos de ensayos**, filtra usando `ensayo_muestra.resultado` y **convierte el campo a número antes de comparar**.
                    - Si la pregunta menciona **tipo de muestra**, usa la tabla `tipo_muestra`.
                    - Si se relacionan muestras con ensayos, usá `ensayo_muestra`.
                    - Si se menciona un año, filtrá por `YEAR(fecha_entrada)` o la columna correspondiente.
                    - Si la pregunta menciona "microbiología", "físico-químico", "biológico", etc., NO buscar en la tabla `muestras`.
                    - En su lugar, hacer JOIN entre `muestras`, `ensayo_muestra` y `ensayos`, y filtrar por `ensayos.tipo_ensayo`.
                    - Ejemplo correcto:
                    SELECT COUNT(DISTINCT m.id)
                    FROM muestras m
                    JOIN ensayo_muestra em ON em.muestra_id = m.id
                    JOIN ensayos e ON em.ensayo_id = e.id
                    WHERE YEAR(m.fecha_entrada) = 2023
                        AND e.tipo_ensayo LIKE '%microbiolog%';
                    - Si la pregunta menciona palabras como "muestras de agua", "alimentos", "efluentes", etc., usar la tabla `matrizs`.
                    - En esos casos, filtrar `muestras.matriz_id` usando el ID de `matrizs` donde `matriz LIKE '%agua%'`.
                    - No usar la tabla `tipomuestras` directamente para esto.
                    - Ejemplo correcto:
                    SELECT COUNT(*) FROM muestras
                    WHERE YEAR(fecha_entrada) = 2023
                        AND matriz_id IN (
                        SELECT id FROM matrizs WHERE matriz LIKE '%agua%'
                    );

                    🔎 Reglas especiales:
                    - Si la pregunta menciona "muestras de agua", buscá en `muestras.matriz_id` haciendo join con `matrizs` por `matriz LIKE '%agua%'`.
                    - Si además menciona "red", "superficial", etc., buscá en `tipomuestras.tipo_muestra` y relacioná con `muestras.tipomuestra_id` y `tipomuestras.matriz_id`.
                    - Si se menciona "ensayos de tipo microbiológico", hacé JOIN entre `muestras`, `ensayo_muestra` y `ensayos`, filtrando por `ensayos.tipo_ensayo`.

                    📌 Ejemplo de SQL correcto:
                    ```sql
                    SELECT COUNT(DISTINCT m.id)
                    FROM muestras m
                    JOIN ensayo_muestra em ON em.muestra_id = m.id
                    JOIN ensayos e ON em.ensayo_id = e.id
                    WHERE YEAR(m.fecha_entrada) = 2023
                    AND e.tipo_ensayo LIKE '%microbiolog%';

                    - Si se consulta por un ensayo (campo `ensayo` o `tipo_ensayo` en la tabla `ensayos`), no uses igualdad exacta (`=`).
                    - En su lugar, usá `LIKE '%recuento%' AND LIKE '%aerobios%'` para cada palabra clave.
                    - Separá la consulta del usuario en palabras, ignorá mayúsculas/minúsculas, y buscá coincidencias parciales en el campo.
                    - Ejemplo correcto:
                    SELECT COUNT(*) FROM ensayos WHERE ensayo LIKE '%recuento%' AND ensayo LIKE '%aerobios%';
        
                    📌 Reglas para el campo `resultado` (VARCHAR):

                    - Si `resultado` comienza con `>` o `<`, usá `SUBSTRING(resultado, 2)` para obtener el número y convertí con `CAST(... AS DECIMAL(10,2))`.
                    - Si `resultado` contiene notación científica (como `1.2E+03`), MySQL puede interpretarlo si lo comparás como `CAST(resultado AS DECIMAL(10,2))`.
                    - Si `resultado` es un número sin símbolos ni letras (ej. `100`, `54.2`), usá `CAST(resultado AS DECIMAL(10,2)) * 1` para convertirlo a número y hacer comparaciones.
                    - Si el valor de `resultado` es `"ND"` (No Detectable), `"traza"`, `"no aplica"` o cualquier texto no numérico, **no intentes convertirlo ni usarlo en comparaciones numéricas**. En estos casos, filtrá usando `WHERE resultado NOT IN ('ND', 'traza', 'no aplica')`.
                    - También podés usar `RLIKE '^[0-9]+(\\.[0-9]+)?(E[+-]?[0-9]+)?$'` para validar si el valor es realmente numérico.
                    - **Siempre usa `CAST(resultado AS DECIMAL(10,2)) * 1` para comparar correctamente.**
                    - **Si `resultado` contiene `>` o `<`, usa `SUBSTRING()` para extraer el número y convertirlo.**

                    📌 Ejemplo de SQL Correcto:

                    ```sql
                    SELECT 
                        COUNT(*) AS muestras_validas
                    FROM ensayo_muestra AS em
                    JOIN ensayos AS e ON em.ensayo_id = e.id
                    WHERE e.ensayo = 'NMP de Escherichia coli'
                    AND resultado NOT IN ('ND', 'traza', 'no aplica')
                    AND (
                        (resultado LIKE '>%' AND CAST(SUBSTRING(resultado, 2) AS DECIMAL(10,2)) > 100)
                        OR (CAST(resultado AS DECIMAL(10,2)) > 100)
                    );
        
                    📌 **En el caso que el campo sea `resultado`:**

                    ✅ Paso 1: Se verifica si el campo resultado comienza con > o < usando LIKE '>%' o LIKE '<%'.
                    ✅ Paso 2: Si resultado contiene > o <, se extrae el número después del operador con SUBSTRING() y se convierte a decimal con CAST() o TRY_CAST().
                    ✅ Paso 3: Si resultado no contiene > ni <, se convierte directamente a número con CAST(resultado AS DECIMAL(10,2)) * 1.
                    ✅ Paso 4: Si resultado está en notación científica (por ejemplo, 1.0E+02), CAST(resultado AS DECIMAL(10,2)) * 1 lo transforma correctamente en su valor numérico (100).
                    ✅ Paso 5: Para evitar errores con valores no numéricos o vacíos, se usa TRY_CAST() (o NULLIF() en MySQL si TRY_CAST() no está disponible).
    
                    Pregunta: {$pregunta}
            EOT
            ]]]
        ]
    ];
    

    try {
        $response = $client->post($apiUrl, [
            'json' => $payload,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'timeout' => 60
        ]);

        $data = json_decode($response->getBody(), true);
        $generatedText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if (preg_match('/```sql(.*?)```/si', $generatedText, $matches)) {
            $sql = trim($matches[1]);
            if (substr(trim($sql), -1) !== ';') $sql .= ';';
// =========================
        // ✅ FILTRO POR ROL
        // =========================
        $restriccionesPorRol = [
            'LabFQAguas' => ['tipo_ensayo' => 'fisico', 'matriz' => 'agua'],
            'LabMicro' => ['tipo_ensayo' => 'microbiolog'],
            'LabBiologico' => ['tipo_ensayo' => 'biologic'],
            'LabCromatografia' => ['tipo_ensayo' => 'cromatograf'],
        ];

        $usuario = auth()->user();
        $rol = $usuario->descripcion_rol ?? null;

        if (isset($restriccionesPorRol[$rol])) {
            $filtros = $restriccionesPorRol[$rol];

            // Asegurar que el SQL no tenga ';' antes de agregar cláusulas
            $sql = rtrim($sql, ';');

            if (stripos($sql, ' where ') !== false) {
                if (isset($filtros['tipo_ensayo'])) {
                    $sql .= " AND e.tipo_ensayo LIKE '%" . $filtros['tipo_ensayo'] . "%'";
                }
                if (isset($filtros['matriz'])) {
                    $sql .= " AND mz.matriz LIKE '%" . $filtros['matriz'] . "%'";
                }
            } else {
                $whereClauses = [];
                if (isset($filtros['tipo_ensayo'])) {
                    $whereClauses[] = "e.tipo_ensayo LIKE '%" . $filtros['tipo_ensayo'] . "%'";
                }
                if (isset($filtros['matriz'])) {
                    $whereClauses[] = "mz.matriz LIKE '%" . $filtros['matriz'] . "%'";
                }
                $sql .= " WHERE " . implode(" AND ", $whereClauses);
            }

            $sql .= ";";
            }   
            Log::info("Consulta SQL generada: " . $sql);

            try {
                $resultados = DB::select($sql);
                $labels = [];
                $values = [];

                if (!empty($resultados)) {
                    $resultado = (array) $resultados[0]; // Convertir la primera fila en array asociativo
                    $labels = array_keys($resultado);
                    $values = array_map('intval', array_values($resultado)); // Convertir los valores a enteros
                }

                // 🔥 Agregamos el Log para ver el JSON completo que se enviará
                Log::info("JSON enviado: " . json_encode([
                    'consulta'   => $sql,
                    'explicacion' => trim(str_replace($matches[0], '', $generatedText)),
                    'resultados' => $resultados,
                    'labels'     => $labels,
                    'data'       => $values
                ]));

                return response()->json([
                    'consulta'   => $sql,
                    'explicacion' => trim(str_replace($matches[0], '', $generatedText)),
                    'resultados' => $resultados,
                    'labels'     => $labels, // 🔥 Etiquetas corregidas
                    'data'       => $values  // 🔥 Valores corregidos
                ]);
            } catch (Exception $dbException) {
                Log::error("Error ejecutando la consulta SQL: " . $dbException->getMessage());
                return response()->json([
                    'error'   => 'Error al ejecutar la consulta en la base de datos.',
                    'detalle' => $dbException->getMessage(),
                    'consulta' => $sql
                ], 500);
            }
        }

        return response()->json([
            'error' => 'No se pudo generar una consulta SQL válida.',
            'detalle' => $data
        ], 500);
    } catch (Exception $e) {
        Log::error("Error en la solicitud a Google AI Studio: " . $e->getMessage());
        return response()->json([
            'error' => 'Error en la solicitud a Google AI Studio.',
            'detalle' => $e->getMessage()
        ], 500);
    }
});

/* IA avanzada */
Route::post('/interpretar-consulta', 'ConsultaIAController@interpretar');