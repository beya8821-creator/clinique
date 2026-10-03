drop policy if exists "Public can submit contact messages" on public.contact_messages;
create policy "Public can submit contact messages" on public.contact_messages for insert to anon with check (true);
drop policy if exists "Public can submit appointments" on public.appointments;
create policy "Public can submit appointments" on public.appointments for insert to anon with check (true);
