# NEXT.JS ARCHITECTURE

## 1. Objectif

Preparer un projet Next.js independant pour migrer progressivement le CMS PHP Polyclinique Yetu, sans modifier le PHP existant, MySQL, les routes actuelles ou l'UI/UX.

## 2. Structure du projet

```text
next-app/
|-- app/
|   |-- (auth)/
|   |-- (dashboard)/
|   |-- (public)/
|   |-- api/
|   |-- error.tsx
|   |-- globals.css
|   |-- layout.tsx
|   |-- loading.tsx
|   |-- not-found.tsx
|   `-- page.tsx
|-- actions/
|-- components/
|   |-- auth/
|   |-- dashboard/
|   |-- layout/
|   |-- public/
|   `-- ui/
|-- hooks/
|-- lib/
|   |-- config/
|   |-- supabase/
|   |-- utils/
|   `-- validations/
|-- public/
|-- styles/
|-- types/
|-- proxy.ts
|-- .env.local.example
|-- next.config.ts
|-- tsconfig.json
|-- package.json
`-- README.md
```

## 3. App Router

Le projet utilise Next.js App Router. Les groupes `(public)`, `(auth)` et `(dashboard)` sont prepares pour les prochaines missions, sans recreer encore les pages PHP.

## 4. Components

Les dossiers de composants sont prepares par domaine :

- `components/ui` pour primitives simples.
- `components/layout` pour shells/layouts.
- `components/public` pour futur site public.
- `components/auth` pour future authentification.
- `components/dashboard` pour futur admin.

## 5. Lib

- `lib/config/env.ts` centralise les variables d'environnement.
- `lib/supabase/browser.ts` cree le client navigateur.
- `lib/supabase/server.ts` cree le client serveur avec cookies.
- `lib/supabase/admin.ts` cree le client service role cote serveur uniquement.
- `lib/utils/routes.ts` centralise les routes protegees.
- `lib/validations/contact.ts` prepare les validations contact/rendez-vous.

## 6. Actions

Le dossier `actions/` est reserve aux futures Server Actions. Aucune action metier n'est encore connectee.

## 7. API

Le dossier `app/api/` est reserve aux futures routes API. Aucune API metier n'est encore creee.

## 8. Supabase

Packages installes :

- `@supabase/supabase-js`
- `@supabase/ssr`

La configuration est preparee mais non connectee a une base reelle. Aucune table Supabase n'a ete creee.

## 9. Authentication

Le proxy prepare la protection future de `/dashboard`. Next.js 16 remplace la convention `middleware.ts` par `proxy.ts`. Si les variables Supabase ne sont pas configurees, il laisse passer les routes afin que le projet reste constructible localement.

Strategie cible :

```text
PUBLIC
  -> AUTHENTICATED
  -> ROLE
      |-- admin
      `-- editor
```

## 10. Types

Les types initiaux representent le futur modele Supabase :

- `types/auth.ts`
- `types/cms.ts`
- `types/database.ts`

Ils servent de fondation et devront etre remplaces ou completes par les types generes Supabase lorsque le schema sera valide.

## 11. Environment variables

Fichier exemple :

- `next-app/.env.local.example`

Variables preparees :

- `NEXT_PUBLIC_SUPABASE_URL`
- `NEXT_PUBLIC_SUPABASE_ANON_KEY`
- `SUPABASE_SERVICE_ROLE_KEY`
- `NEXT_PUBLIC_SITE_URL`

La cle service role ne doit jamais etre utilisee dans un composant client.

## 12. Security

- `.env.local` est ignore par Git.
- `.env.local.example` est autorise pour documentation.
- Le client admin importe `server-only`.
- Le proxy ne connecte Supabase que si les variables publiques existent.
- Aucun secret reel n'a ete ajoute.

## 13. Styling

`app/globals.css` contient uniquement une fondation neutre : tokens, reset, focus visible, layout de page de preparation. La reproduction fidele BootstrapMade/PHP est reservee a MISSION-04.

## 14. Validation

Zod est installe pour preparer les validations futures. Les premiers schemas couvrent contact et rendez-vous, sans connexion a la base.

## 15. Error handling

Fichiers prepares :

- `app/error.tsx`
- `app/not-found.tsx`
- `app/loading.tsx`

## 16. Build

Commandes prevues :

```bash
npm run lint
npm run build
npm run dev
```

## 17. Decisions techniques

- Projet cree dans `next-app/` pour coexister avec le PHP.
- App Router active.
- TypeScript strict conserve.
- Alias `@/*` conserve.
- Pas de librairie UI ajoutee.
- Supabase prepare avec separation browser/server/admin.
- Zod ajoute pour validations.
- Pas de migration de donnees.
- Pas de modification fonctionnelle PHP.

## 18. Elements restant a implementer

- Reproduction fidele de l'UI/UX publique.
- Migration des pages publiques.
- Login Supabase Auth.
- Dashboard admin Next.js.
- Server Actions formulaires.
- Connexion Supabase reelle de developpement.
- Generation officielle des types depuis Supabase.
- Tests Playwright/visuels.
