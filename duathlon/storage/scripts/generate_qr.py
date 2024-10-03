import qrcode
import sys
import os
import json

def convert_to_json(data):
    try:
        # Prova a convertire direttamente il data in JSON
        data_dict = json.loads(data)
        return json.dumps(data_dict, ensure_ascii=False)
    except json.JSONDecodeError:
        # Se non è un JSON valido, converti manualmente
        data = data.replace('{', '{"').replace('}', '"}').replace(':', '":"').replace(',', '","')
        return data

def generate_qr_code(data, output_file):
    try:
        data_json = convert_to_json(data)
        # Crea un oggetto QR Code
        qr = qrcode.QRCode(
            version=1,
            error_correction=qrcode.constants.ERROR_CORRECT_L,
            box_size=10,
            border=4,
        )
        qr.add_data(data_json)
        qr.make(fit=True)

        # Crea un'immagine del QR Code
        img = qr.make_image(fill='black', back_color='white')

        # Verifica la directory di output
        output_dir = os.path.dirname(output_file)
        if not os.path.exists(output_dir):
            os.makedirs(output_dir)
            print(f"Directory creata: {output_dir}")

        # Salva l'immagine
        img.save(output_file)
        print(f"QR code salvato in: {output_file}")

    except Exception as e:
        print(f"Errore nella generazione del QR code: {e}")

if __name__ == "__main__":
    if len(sys.argv) != 3:
        print("Uso: python generate_qr.py <data> <output_file>")
        sys.exit(1)

    data = sys.argv[1]
    output_file = sys.argv[2]
    generate_qr_code(data, output_file)

