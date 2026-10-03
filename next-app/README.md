# Polyclinique Yetu Next.js

Projet Next.js prepare pour la migration progressive du CMS PHP Polyclinique Yetu.

Le site PHP reste la reference fonctionnelle pendant cette phase. Ce projet est independant et ne remplace pas encore MySQL, les routes PHP ou l'interface existante.

## Installation

```bash
npm install
```

## Environnement

```bash
cp .env.local.example .env.local
```

Renseigner les variables Supabase uniquement quand un projet Supabase de developpement est disponible.

```text
NEXT_PUBLIC_SUPABASE_URL=
NEXT_PUBLIC_SUPABASE_ANON_KEY=
SUPABASE_SERVICE_ROLE_KEY=
NEXT_PUBLIC_SITE_URL=http://localhost:3000
```

Ne jamais exposer `SUPABASE_SERVICE_ROLE_KEY` cote navigateur.

## Demarrage

```bash
npm run dev
```

Ouvrir `http://localhost:3000`.

## Verification

```bash
npm run lint
npm run build
```

## Architecture

- `app/` : App Router, layouts, pages, erreurs.
- `components/` : composants UI, layout, public, auth, dashboard.
- `lib/supabase/` : clients browser, server et admin.
- `lib/validations/` : schemas de validation.
- `types/` : types du futur modele Supabase.
- `actions/` : futures Server Actions.
- `proxy.ts` : base de protection auth pour le futur dashboard avec la convention Next.js 16.

## Supabase

Packages installes :

- `@supabase/supabase-js`
- `@supabase/ssr`

La connexion reelle n'est pas active tant que `.env.local` ne contient pas les valeurs d'un projet Supabase valide.

### Authentification et formulaires

1. Executer `supabase/cms-schema.sql` dans le SQL Editor du projet Supabase.
2. Dans Supabase Authentication, creer l'utilisateur administrateur avec son adresse e-mail et son mot de passe.
3. Recuperer son UUID dans Authentication, puis creer son profil avec la requete suivante :

```sql
insert into public.profiles (id, display_name, role, status)
values ('UUID_DE_L_UTILISATEUR', 'Administrateur', 'admin', 'active')
on conflict (id) do update
set role = excluded.role, status = excluded.status;
```

4. Copier les cles Supabase dans `next-app/.env.local`, puis redemarrer `npm run dev`.

La page `/login` utilise `signInWithPassword`. La deconnexion du menu administrateur detruit la session Supabase et renvoie vers `/login`. Les formulaires `/contact` et `/appointment` valident les champs cote serveur et enregistrent les demandes dans `contact_messages` et `appointments`.

La cle `SUPABASE_SERVICE_ROLE_KEY` reste uniquement cote serveur : elle sert a enregistrer les formulaires publics et ne doit jamais etre ajoutee dans une variable `NEXT_PUBLIC_*`.

## Tests

Il n'y a pas encore de tests fonctionnels. La verification actuelle repose sur lint, build et demarrage dev.
