# ADMIN UI DIRECTION - POLYCLINIQUE YETU

## Objectif

Creer un back-office professionnel, medical, simple a utiliser, coherent avec le site public, et pret pour Supabase Auth + RLS.

## Decision Principale

Ne pas migrer l'ancien admin PHP tel quel.

Garder :

- Les fonctionnalites.
- La logique metier.
- Les donnees.

Refaire :

- L'organisation.
- La navigation.
- Le design.
- Les formulaires.
- Les etats utilisateur.

## Branding

Nom affiche :

- Polyclinique Yetu Admin

Direction visuelle :

- Interface claire et medicale.
- Fond gris tres clair.
- Surfaces blanches.
- Bleu medical comme couleur primaire.
- Vert sante comme couleur secondaire.
- Rouge uniquement pour les suppressions ou erreurs.
- Logo du site public dans le header.

## Architecture Cible

- `/login`
- `/dashboard`
- `/dashboard/content/home`
- `/dashboard/content/about`
- `/dashboard/content/services`
- `/dashboard/content/contact`
- `/dashboard/content/pages`
- `/dashboard/content/hero-slider`
- `/dashboard/appointments`
- `/dashboard/messages`
- `/dashboard/newsletter`
- `/dashboard/media`
- `/dashboard/users`
- `/dashboard/settings`
- `/dashboard/activity`

Les anciennes routes `cms-home`, `cms-about`, `cms-services`, `cms-contact`, `pages` et `hero-slider` doivent rediriger vers les nouvelles routes propres pendant la transition.

## Navigation

Vue generale :

- Dashboard

Contenu du site :

- Accueil
- A propos
- Services
- Contact
- Pages avancees
- Hero Slider

Patients :

- Rendez-vous
- Messages
- Newsletter

Bibliotheque :

- Medias

Administration :

- Utilisateurs
- Parametres
- Activite

## Ecrans Prioritaires

1. Login
2. Dashboard
3. Rendez-vous
4. Messages
5. Medias
6. Contenu accueil
7. Contenu about/services/contact
8. Utilisateurs
9. Parametres
10. Activite

## Etats UI Obligatoires

Chaque ecran doit prevoir :

- Loading.
- Empty state.
- Error state.
- Success state.
- Unsaved changes.
- Confirmation suppression.

## Statuts Metier

Rendez-vous :

- En attente.
- Confirme.
- Annule.
- Traite.

Messages :

- Non lu.
- Lu.
- Archive.

Services :

- Publie.
- Brouillon.

Utilisateurs :

- Actif.
- Suspendu.

## Roles

Admin :

- Acces complet.

Editor :

- Modifier le contenu.
- Gerer les medias.
- Consulter messages/rendez-vous selon validation metier.
- Pas de gestion utilisateurs.
- Pas de parametres sensibles.
