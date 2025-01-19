<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accordion with Plus/Minus Icon</title>
    <style>
        .accordion-button {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }

        .accordion-button::after {
            flex-shrink: 0;
            width: 16px; /* Fixed width for the icon */
            height: 16px;
            margin-left: auto;
            content: "";
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='%23212529' stroke-linecap='round' stroke-linejoin='round'%3e%3cpath d='M8 1v14M1 8h14'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-size: 16px 16px;
            transition: transform 0.3s ease;
        }

        .accordion-button.active::after {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none' stroke='%23212529' stroke-linecap='round' stroke-linejoin='round'%3e%3cpath d='M2 5L8 11L14 5'/%3e%3c/svg%3e");
        }

        .accordion-content {
            display: none;
            padding: 10px;
            border-top: 1px solid #dee2e6;
        }

        .accordion-content.active {
            display: block;
        }
    </style>
</head>
<body>

    <div class="accordion">
        <div class="accordion-button">Click me</div>
        <div class="accordion-content">This is the content that toggles.</div>
    </div>

    <script>
        document.querySelector('.accordion-button').addEventListener('click', function() {
            this.classList.toggle('active');
            document.querySelector('.accordion-content').classList.toggle('active');
        });
    </script>
    
</body>
</html>
