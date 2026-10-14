import { useRef, useState } from 'react';
import { UploadSimple } from '@phosphor-icons/react';
import { cn } from '@/Lib/cn';

export function FileUpload({
    accept = 'image/*',
    maxSizeMb = 5,
    onChange,
    error,
    label = 'Drop an image or click to browse',
    hint,
    className,
}) {
    const [preview, setPreview] = useState(null);
    const [localError, setLocalError] = useState('');
    const [dragging, setDragging] = useState(false);
    const inputRef = useRef(null);

    function processFile(file) {
        if (!file) return;
        setLocalError('');
        if (maxSizeMb && file.size > maxSizeMb * 1024 * 1024) {
            setLocalError(`File must be under ${maxSizeMb} MB`);
            return;
        }
        if (file.type?.startsWith('image/')) {
            setPreview(URL.createObjectURL(file));
        } else {
            setPreview(null);
        }
        onChange?.(file);
    }

    return (
        <div
            className={cn('ge-file', dragging && 'ge-file--dragging', className)}
            onClick={() => inputRef.current?.click()}
            onDragOver={(e) => { e.preventDefault(); setDragging(true); }}
            onDragLeave={() => setDragging(false)}
            onDrop={(e) => {
                e.preventDefault();
                setDragging(false);
                processFile(e.dataTransfer.files?.[0]);
            }}
        >
            <input
                ref={inputRef}
                type="file"
                accept={accept}
                hidden
                onChange={(e) => processFile(e.target.files?.[0])}
            />
            <UploadSimple weight="bold" size={28} />
            <div>{label}</div>
            {hint ? <div className="ge-file__hint">{hint}</div> : null}
            {preview ? (
                <div className="ge-file__preview">
                    <img src={preview} alt="Preview" />
                </div>
            ) : null}
            {(error || localError) ? <div className="ge-field__error">{error || localError}</div> : null}
        </div>
    );
}
