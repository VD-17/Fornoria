import sharp from 'sharp';
import path from 'path';
import fs from 'fs';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

const SOURCE = path.resolve(__dirname, 'public/images/icons/source.png');
const OUTPUT = path.resolve(__dirname, 'public/images/icons');

const SIZES = [72, 96, 128, 144, 152, 192, 384, 512];

async function generate() {
    if (!fs.existsSync(SOURCE)) {
        console.error(`\n❌ Source file not found: ${SOURCE}`);
        console.error('   Place a 512×512+ PNG at public/icons/source.png and try again.\n');
        process.exit(1);
    }

    if (!fs.existsSync(OUTPUT)) fs.mkdirSync(OUTPUT, { recursive: true });

    for (const size of SIZES) {
        const dest = path.join(OUTPUT, `icon-${size}x${size}.png`);
        await sharp(SOURCE)
            .resize(size, size, { fit: 'contain', background: { r: 26, g: 10, b: 0, alpha: 1 } })
            .png()
            .toFile(dest);
        console.log(`✓ icon-${size}x${size}.png`);
    }

    // Badge icon (72×72 monochrome for notifications)
    await sharp(SOURCE)
        .resize(72, 72)
        .grayscale()
        .png()
        .toFile(path.join(OUTPUT, 'badge-72x72.png'));
    console.log('✓ badge-72x72.png');

    console.log('\n✅ All icons generated in public/icons/');
}

generate().catch(console.error)
