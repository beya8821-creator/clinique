"use client";

import { useEffect } from "react";

import { HeroSlide, heroSliderStorageKey } from "@/lib/hero-slides";

declare global {
  interface Window {
    AOS?: {
      init: (options?: Record<string, unknown>) => void;
      refresh?: () => void;
    };
    bootstrap?: {
      Carousel?: {
        getOrCreateInstance: (
          element: Element,
          options?: Record<string, unknown>,
        ) => {
          cycle: () => void;
        };
      };
    };
    PureCounter?: new () => unknown;
  }
}

function readStoredHeroSlides() {
  const storedValue = window.localStorage.getItem(heroSliderStorageKey);

  if (!storedValue) {
    return [];
  }

  try {
    const parsedValue = JSON.parse(storedValue) as Partial<HeroSlide>[];

    if (!Array.isArray(parsedValue)) {
      return [];
    }

    return parsedValue.filter(
      (slide): slide is HeroSlide =>
        slide.status === "published" &&
        typeof slide.id === "string" &&
        typeof slide.image === "string" &&
        typeof slide.alt === "string" &&
        typeof slide.title === "string",
    );
  } catch {
    return [];
  }
}

function syncHeroCarouselFromDashboard() {
  const carousel = document.querySelector("#heroImageCarousel");
  const carouselInner = carousel?.querySelector(".carousel-inner");
  const carouselIndicators = carousel?.querySelector(".carousel-indicators");
  const slides = readStoredHeroSlides();

  if (!carousel || !carouselInner || !carouselIndicators || slides.length === 0) {
    return;
  }

  carouselIndicators.replaceChildren();
  carouselInner.replaceChildren();

  slides.forEach((slide, index) => {
    const indicator = document.createElement("button");
    const item = document.createElement("div");
    const image = document.createElement("img");

    indicator.type = "button";
    indicator.dataset.bsTarget = "#heroImageCarousel";
    indicator.dataset.bsSlideTo = String(index);
    indicator.ariaLabel = slide.title;

    if (index === 0) {
      indicator.classList.add("active");
      indicator.setAttribute("aria-current", "true");
    }

    item.className = index === 0 ? "carousel-item active" : "carousel-item";
    image.src = slide.image;
    image.alt = slide.alt;
    image.className = "img-fluid";

    item.append(image);
    carouselIndicators.append(indicator);
    carouselInner.append(item);
  });

  window.bootstrap?.Carousel?.getOrCreateInstance(carousel, {
    interval: 4200,
    pause: false,
    ride: "carousel",
  }).cycle();
}

function refreshPureCounters() {
  document.querySelectorAll<HTMLElement>("[data-purecounter-end]").forEach((counter) => {
    counter.classList.add("purecounter");
    counter.textContent = counter.dataset.purecounterStart ?? "0";
  });

  if (window.PureCounter) {
    new window.PureCounter();
  }
}

function removePreloader() {
  const preloader = document.querySelector("#preloader");

  window.setTimeout(() => {
    preloader?.remove();
  }, 250);
}

export function BootstrapMadeRuntime() {
  useEffect(() => {
    window.AOS?.init({
      duration: 600,
      easing: "ease-in-out",
      once: true,
      mirror: false,
    });
    window.AOS?.refresh?.();
    refreshPureCounters();
    syncHeroCarouselFromDashboard();
    removePreloader();

    window.addEventListener("hero-slides-updated", syncHeroCarouselFromDashboard);

    return () => {
      window.removeEventListener("hero-slides-updated", syncHeroCarouselFromDashboard);
    };
  }, []);

  return null;
}
