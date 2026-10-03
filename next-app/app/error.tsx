"use client";

type ErrorPageProps = {
  error: Error & { digest?: string };
  reset: () => void;
};

export default function ErrorPage({ error, reset }: ErrorPageProps) {
  return (
    <main className="app-shell">
      <section className="migration-panel" aria-labelledby="error-title">
        <p className="eyebrow">Erreur</p>
        <h1 id="error-title">Une erreur est survenue</h1>
        <p>{error.message || "La page n'a pas pu etre chargee."}</p>
        <button type="button" onClick={reset}>
          Reessayer
        </button>
      </section>
    </main>
  );
}
