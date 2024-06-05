# Shoe Size Converter

This PHP script converts EU shoe sizes to US, UK, and CM sizes based on the provided data.

## Usage

To use the script, provide an EU shoe size as a query parameter in the URL.

Example:
```
http://yourdomain.com/index.php?eu_size=42
```

## Project Structure

```
shoe_size_converter/
├── README.md
├── index.php
└── data/
    └── shoe_sizes.csv
```

- `index.php`: The main PHP script that performs the conversion.
- `data/shoe_sizes.csv`: The CSV file containing the shoe size data.
- `README.md`: This file.

## Data Quality and Sources

The data used in this project is sourced from [Blitzrechner.de](https://www.blitzrechner.de/schuhgroessen-berechnen/) and the [ISO 19407:2015 standard](https://www.iso.org/standard/83106.html). These sources provide reliable and standardized measurements for shoe sizes across different regions, ensuring the accuracy and consistency of the conversion results. The data includes conversions for EU, US, and UK shoe sizes as well as the corresponding measurements in centimeters.
