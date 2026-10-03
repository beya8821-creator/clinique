import Link from "next/link";

import { signInAction } from "@/app/actions/auth";

type LoginPageProps = {
  searchParams: Promise<Record<string, string | string[] | undefined>>;
};

function firstParam(value: string | string[] | undefined) {
  return Array.isArray(value) ? value[0] : value;
}

function getStatusMessage(status: string | undefined) {
  switch (status) {
    case "signed-out":
      return { tone: "success", text: "Vous êtes bien déconnecté." };
    case "invalid":
      return { tone: "error", text: "Saisissez votre adresse e-mail et votre mot de passe." };
    case "error":
      return { tone: "error", text: "Adresse e-mail ou mot de passe incorrect." };
    case "supabase-missing":
      return { tone: "error", text: "L’authentification Supabase doit encore être configurée." };
    default:
      return null;
  }
}

export default async function LoginPage({ searchParams }: LoginPageProps) {
  const params = await searchParams;
  const status = getStatusMessage(firstParam(params.status));
  const nextPath = firstParam(params.next)?.startsWith("/") ? firstParam(params.next) : "/dashboard";

  return (
    <main className="admin-login">
      <section className="admin-login-card" aria-labelledby="login-title">
        <div className="admin-login-brand">
          <img src="/assets/img/logo.png" alt="Polyclinique Yetu" />
          <div>
            <p>Administration</p>
            <h1 id="login-title">Connexion</h1>
          </div>
        </div>

        <p className="admin-login-intro">Accédez à la gestion du site de la Polyclinique Yetu.</p>

        {status ? (
          <p className={`admin-login-status ${status.tone}`} role="status">
            {status.text}
          </p>
        ) : null}

        <form action={signInAction}>
          <input type="hidden" name="next" value={nextPath} />

          <label htmlFor="login-email">
            Adresse e-mail
            <input id="login-email" name="email" type="email" autoComplete="email" required />
          </label>

          <label htmlFor="login-password">
            Mot de passe
            <input
              id="login-password"
              name="password"
              type="password"
              autoComplete="current-password"
              required
            />
          </label>

          <button type="submit" className="admin-login-submit">
            Se connecter
            <i className="bi bi-arrow-right" aria-hidden="true" />
          </button>
        </form>

        <Link href="/" className="admin-login-back">
          <i className="bi bi-arrow-left" aria-hidden="true" /> Retour au site
        </Link>
      </section>
    </main>
  );
}
