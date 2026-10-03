"use client";

import { ChangeEvent, useMemo, useState } from "react";

import { HeroSlide, defaultHeroSlides, heroSliderStorageKey } from "@/lib/hero-slides";

function createSlideId() {
  if (typeof crypto !== "undefined" && "randomUUID" in crypto) {
    return crypto.randomUUID();
  }

  return `hero-${Date.now()}`;
}

function readSlidesFromStorage() {
  const storedValue = window.localStorage.getItem(heroSliderStorageKey);

  if (!storedValue) {
    return defaultHeroSlides;
  }

  try {
    const parsedValue = JSON.parse(storedValue) as HeroSlide[];

    if (!Array.isArray(parsedValue) || parsedValue.length === 0) {
      return defaultHeroSlides;
    }

    return parsedValue;
  } catch {
    return defaultHeroSlides;
  }
}

function readFileAsDataUrl(file: File) {
  return new Promise<string>((resolve, reject) => {
    const reader = new FileReader();

    reader.onload = () => {
      if (typeof reader.result === "string") {
        resolve(reader.result);
      } else {
        reject(new Error("Format de fichier non supporte."));
      }
    };
    reader.onerror = () => reject(new Error("Impossible de lire le fichier."));
    reader.readAsDataURL(file);
  });
}

export function HeroSliderManager() {
  const [slides, setSlides] = useState<HeroSlide[]>(() =>
    typeof window === "undefined" ? defaultHeroSlides : readSlidesFromStorage(),
  );
  const [selectedId, setSelectedId] = useState(() => {
    const initialSlides = typeof window === "undefined" ? defaultHeroSlides : readSlidesFromStorage();

    return initialSlides[0]?.id ?? "";
  });
  const [statusMessage, setStatusMessage] = useState("Gestion du hero prete.");

  const selectedSlide = useMemo(
    () => slides.find((slide) => slide.id === selectedId) ?? slides[0],
    [selectedId, slides],
  );

  function saveSlides(nextSlides: HeroSlide[], message = "Hero Slider sauvegarde.") {
    setSlides(nextSlides);

    if (!nextSlides.some((slide) => slide.id === selectedId)) {
      setSelectedId(nextSlides[0]?.id ?? "");
    }

    try {
      window.localStorage.setItem(heroSliderStorageKey, JSON.stringify(nextSlides));
      window.dispatchEvent(new Event("hero-slides-updated"));
      setStatusMessage(message);
    } catch {
      setStatusMessage("Le navigateur n'a pas pu sauvegarder ces images. Essayez avec des fichiers plus legers.");
    }
  }

  async function handleUpload(event: ChangeEvent<HTMLInputElement>) {
    const files = Array.from(event.target.files ?? []).filter((file) => file.type.startsWith("image/"));

    if (files.length === 0) {
      return;
    }

    setStatusMessage("Preparation des images...");

    try {
      const uploadedSlides = await Promise.all(
        files.map(async (file) => ({
          alt: `Image hero ${file.name}`,
          id: createSlideId(),
          image: await readFileAsDataUrl(file),
          status: "published" as const,
          title: file.name.replace(/\.[^.]+$/, ""),
        })),
      );
      const nextSlides = [...slides, ...uploadedSlides];

      saveSlides(nextSlides, `${uploadedSlides.length} image(s) ajoutee(s) au Hero Slider.`);
      setSelectedId(uploadedSlides[0]?.id ?? selectedId);
      event.target.value = "";
    } catch {
      setStatusMessage("Impossible d'ajouter ces images.");
    }
  }

  function updateSlide(slideId: string, updates: Partial<HeroSlide>) {
    const nextSlides = slides.map((slide) => (slide.id === slideId ? { ...slide, ...updates } : slide));

    saveSlides(nextSlides, "Modification sauvegardee.");
  }

  function moveSlide(slideId: string, direction: -1 | 1) {
    const slideIndex = slides.findIndex((slide) => slide.id === slideId);
    const targetIndex = slideIndex + direction;

    if (slideIndex < 0 || targetIndex < 0 || targetIndex >= slides.length) {
      return;
    }

    const nextSlides = [...slides];
    const [movedSlide] = nextSlides.splice(slideIndex, 1);
    nextSlides.splice(targetIndex, 0, movedSlide);
    saveSlides(nextSlides, "Ordre des slides mis a jour.");
  }

  function deleteSlide(slideId: string) {
    const nextSlides = slides.filter((slide) => slide.id !== slideId);

    saveSlides(nextSlides.length > 0 ? nextSlides : defaultHeroSlides, "Slide supprimee.");
  }

  function resetSlides() {
    saveSlides(defaultHeroSlides, "Hero Slider reinitialise avec les images par defaut.");
    setSelectedId(defaultHeroSlides[0]?.id ?? "");
  }

  return (
    <div className="admin-stack hero-slider-manager">
      <section className="admin-content-toolbar">
        <div>
          <strong>Hero Slider de la page d&apos;accueil</strong>
          <span>Ajoutez des images, publiez-les et verifiez le rendu avant la connexion Supabase.</span>
        </div>
        <a href="/" className="admin-secondary-action" target="_blank" rel="noreferrer">
          Voir le site
        </a>
      </section>

      <section className="admin-form-panel hero-slider-upload">
        <div className="admin-panel-header">
          <h2>Uploader des photos</h2>
          <span className="admin-badge success">{slides.filter((slide) => slide.status === "published").length} publiees</span>
        </div>
        <label>
          Images du hero
          <input type="file" accept="image/*" multiple onChange={handleUpload} />
        </label>
        <p className="admin-help-text">
          Les images ajoutees ici sont sauvegardees dans le navigateur pour cette mission. La prochaine etape sera de les brancher
          sur Supabase Storage.
        </p>
        <div className="admin-form-actions">
          <button type="button" onClick={resetSlides} className="admin-secondary-action">
            Reinitialiser
          </button>
          <span className="admin-save-state">{statusMessage}</span>
        </div>
      </section>

      <section className="hero-slider-workspace">
        <div className="hero-slider-list">
          {slides.map((slide, index) => (
            <article className={slide.id === selectedSlide?.id ? "hero-slide-row active" : "hero-slide-row"} key={slide.id}>
              <button type="button" className="hero-slide-select" onClick={() => setSelectedId(slide.id)}>
                <img src={slide.image} alt="" />
                <span>
                  <strong>{slide.title}</strong>
                  <small>
                    Slide {index + 1} · {slide.status === "published" ? "Publiee" : "Brouillon"}
                  </small>
                </span>
              </button>
              <div className="hero-slide-row-actions">
                <button type="button" onClick={() => moveSlide(slide.id, -1)} disabled={index === 0} aria-label="Monter la slide">
                  <i className="bi bi-arrow-up" aria-hidden="true" />
                </button>
                <button type="button" onClick={() => moveSlide(slide.id, 1)} disabled={index === slides.length - 1} aria-label="Descendre la slide">
                  <i className="bi bi-arrow-down" aria-hidden="true" />
                </button>
                <button type="button" className="admin-danger" onClick={() => deleteSlide(slide.id)}>
                  Supprimer
                </button>
              </div>
            </article>
          ))}
        </div>

        {selectedSlide ? (
          <form className="admin-form-panel hero-slide-editor">
            <div className="admin-panel-header">
              <h2>Modifier la slide</h2>
              <span className="admin-badge">Apercu</span>
            </div>
            <div className="hero-slide-preview">
              <img src={selectedSlide.image} alt={selectedSlide.alt} />
            </div>
            <label>
              Titre interne
              <input value={selectedSlide.title} onChange={(event) => updateSlide(selectedSlide.id, { title: event.target.value })} />
            </label>
            <label>
              Texte alternatif
              <input value={selectedSlide.alt} onChange={(event) => updateSlide(selectedSlide.id, { alt: event.target.value })} />
            </label>
            <label>
              Statut
              <select
                value={selectedSlide.status}
                onChange={(event) => updateSlide(selectedSlide.id, { status: event.target.value as HeroSlide["status"] })}
              >
                <option value="published">Publiee</option>
                <option value="draft">Brouillon</option>
              </select>
            </label>
          </form>
        ) : null}
      </section>
    </div>
  );
}
