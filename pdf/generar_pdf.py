from reportlab.lib.pagesizes import A4
from reportlab.pdfgen import canvas
import json
import os

def draw_task(c, tarea, y):
    c.drawString(100, y, f"NOMBRE TAREA: {tarea['nombre_tarea']}")
    
    # Manejar la descripción con saltos de línea
    descripcion = tarea['descripcion']
    lines = split_description(descripcion, 70)  # Llamar a la función para dividir la descripción
    
    # Dibujar la sección de DESCRIPCIÓN una sola vez con saltos de línea
    c.drawString(120, y - 20, "DESCRIPCIÓN:")
    for line in lines:
        c.drawString(140, y - 40, line)
        y -= 20  # Ajustar la posición para la siguiente línea

    c.drawString(100, y - 40, f"Fecha de entrega: {tarea['fecha_entrega']}")
    c.drawString(100, y - 60, f"Estado: {tarea['estado']}")
    c.drawString(100, y - 80, f"Fecha creación: {tarea['created_at']}")
    c.drawString(100, y - 100, f"Persona Asignada: {tarea['asignado_a']}")
    c.drawString(100, y - 120, "--------------------------------------------------------------------------------------------------------------")
    return y - 140  # Retornar la nueva posición Y

def split_description(text, max_length):
    lines = []
    while len(text) > max_length:
        line = text[:max_length]
        if text[max_length] != ' ':
            idx = line.rfind(' ')
            if idx == -1:
                idx = max_length
        else:
            idx = max_length
        lines.append(text[:idx].strip())
        text = text[idx:].strip()
    lines.append(text)
    return lines

try:
    # Ruta del archivo JSON generado por PHP
    ruta_json = 'datos_tareas.json'

    # Leer el archivo JSON con los datos de las tareas
    with open(ruta_json, 'r', encoding='utf-8') as file:
        tareas = json.load(file)

    # Ruta donde se guardará el archivo PDF
    ruta_carpeta = r'C:\Users\USUARIO\proyecto_acero\pdf'
    archivo_pdf = 'informe_tareas.pdf'
    ruta_archivo = os.path.join(ruta_carpeta, archivo_pdf)

    # Generar el PDF con las tareas
    c = canvas.Canvas(ruta_archivo, pagesize=A4)
    y = 750  # Posición inicial para escribir
    contador_tareas = 0

    for tarea in tareas:
        y = draw_task(c, tarea, y)
        contador_tareas += 1
        
        # Después de dibujar dos informes, agregar un salto de página
        if contador_tareas % 2 == 0:
            c.showPage()
            y = 750  # Reiniciar la posición Y para la nueva página

    # Guardar el PDF final
    c.save()

    print(f"PDF generado en: {ruta_archivo}")  # Imprimir mensaje de éxito

except Exception as e:
    print(f"Error al generar el PDF: {str(e)}")
