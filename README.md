# Web scraping de Indicadores  Previsionales PREVIRED

Este script en PHP realiza el scraping de indicadores previsionales desde el sitio web [Previred](https://www.previred.com/indicadores-previsionales/). El script utiliza la biblioteca Goutte para realizar solicitudes HTTP y extraer información de las tablas relevantes en la página.

## Funciones

### `convertirStringFloat($valor)`

Convierte una cadena que representa un valor numérico a un número decimal (float). Elimina caracteres no numéricos y formatea adecuadamente la coma para obtener un valor decimal válido.

### `cortarDecimales($valor)`

Formatea un número decimal a dos decimales.

## Variables

- `$periodo`: Almacena el periodo para el cual se obtuvieron los indicadores previsionales.
- `$valoresUF`: Almacena los valores de la Unidad de Fomento (UF).
- `$valorUTM`: Almacena el valor de la Unidad Tributaria Mensual (UTM).
- `$rentasMinimasImponibles`: Almacena las rentas mínimas imponibles.
- `$ahorroPrevisionalVoluntario`: Almacena los valores del Ahorro Previsional Voluntario (APV).
- `$valorSIS`: Almacena los valores del Seguro de Invalidez y Sobrevivencia (SIS).

## Proceso de Scraping

1. Se inicializa un cliente Goutte y se realiza una solicitud GET a la URL de Previred.
2. Se extrae el periodo desde la tabla correspondiente.
3. Se obtienen los valores de la UF desde la tabla respectiva.
4. Se obtiene el valor de la UTM desde la tabla correspondiente.
5. Se obtienen las rentas mínimas imponibles desde la tabla respectiva.
6. Se obtienen los valores del APV desde la tabla correspondiente.
7. Se obtienen los valores del SIS desde la tabla respectiva.
8. Se aplican las funciones de conversión a los valores extraídos.
9. Se construye un array asociativo con la información obtenida.
10. Se imprime la información en formato JSON.

## Uso de la Información

La información obtenida se presenta en formato JSON con las siguientes claves:

- `periodo`: Periodo para el cual se obtuvieron los indicadores.
- `valoresUF`: Valores de la Unidad de Fomento.
- `valorUTM`: Valor de la Unidad Tributaria Mensual.
- `rentasMinimasImponibles`: Rentas mínimas imponibles.
- `ahorroPrevisionalVoluntario`: Valores del Ahorro Previsional Voluntario.
- `valorSIS`: Valores del Seguro de Invalidez y Sobrevivencia.

La salida está configurada como una respuesta JSON con el encabezado `Content-Type` establecido como `application/json`.