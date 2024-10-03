<!DOCTYPE html>
<html>
<head>
    <title>Stampa QR Code</title>
    <style>
        @media print {
            /* Rimuovi margini e padding */
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
            }
            /* Nascondi tutto ciò che non è necessario per la stampa */
            .no-print {
                display: none;
            }
            /* Centra il contenuto di stampa */
            .print-container {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
                padding: 0;
            }
            /* Rimuovi le intestazioni e i piè di pagina del browser */
            @page {
                margin: 0; /* Margini della pagina */
            }
            /* Stile dell'immagine */
            img {
                max-width: 100%;
                height: auto;
                border: none;
                box-shadow: none;
            }
            /* Stile per la sezione delle informazioni */
            .info-container {
                margin-left: 20px;
                text-align: left;
            }
        }
        .print-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
            padding: 20px;
            border: 1px solid #000;
        }
        .info-container {
            margin-left: 20px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <!-- Immagine del QR code -->
        <div>
            <img src="{{ asset('storage/' . $pdf_path) }}" alt="QR Code">
        </div>
        <!-- Informazioni dell'atleta o della coppia -->
        <div class="info-container">
            @if ($athlete->category->type == 'singolo')
                <h3>Informazioni Atleta</h3>
                <p><strong>ID:</strong> {{ $athlete->id }}</p>
                <p><strong>Nome:</strong> {{ $athlete->first_name }}</p>
                <p><strong>Cognome:</strong> {{ $athlete->last_name }}</p>
                <p><strong>Data di nascita:</strong> {{ $athlete->birth_date }}</p>
                <p><strong>Categoria:</strong> {{$athlete->category->name}} 
            @elseif ($athlete->category->type == 'coppia')
                <h3>Informazioni Coppia</h3>
                <p><strong>ID Team:</strong> {{ $athlete->id }}</p>
                <p><strong>ID Atleta 1:</strong> {{ $athlete->athletes[0]->id }}</p>
                <p><strong>Nome Atleta 1:</strong> {{ $athlete->athletes[0]->first_name }}</p>
                <p><strong>Cognome Atleta 1:</strong> {{ $athlete->athletes[0]->last_name }}</p>
                <p><strong>Data di nascita Atleta 1:</strong> {{ $athlete->athletes[0]->birth_date }}</p>
                <p><strong>ID Atleta 2:</strong> {{ $athlete->athletes[1]->id }}</p>
                <p><strong>Nome Atleta 2:</strong> {{ $athlete->athletes[1]->first_name }}</p>
                <p><strong>Cognome Atleta 2:</strong> {{ $athlete->athletes[1]->last_name }}</p>
                <p><strong>Data di nascita Atleta 2:</strong> {{ $athlete->athletes[1]->birth_date }}</p>
                <p><strong>Categoria:</strong> {{$athlete->category->name}} 
            @endif
        </div>
    </div>

    <!-- Pulsante di stampa -->
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();" class="btn btn-primary">Stampa QR Code</button>
    </div>
</body>
</html>
