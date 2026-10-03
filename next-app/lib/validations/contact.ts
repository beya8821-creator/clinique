import { z } from "zod";

export const contactMessageSchema = z.object({
  name: z.string().trim().min(1).max(120),
  email: z.email().max(190),
  subject: z.string().trim().min(1).max(190),
  message: z.string().trim().min(1).max(5000),
  website: z.string().trim().max(0).optional(),
});

export const appointmentSchema = z.object({
  name: z.string().trim().min(1).max(120),
  email: z.email().max(190),
  phone: z.string().trim().min(1).max(80),
  appointmentDate: z.string().trim().max(80).optional(),
  appointmentTime: z.string().trim().max(80).optional(),
  department: z.string().trim().max(120).optional(),
  doctor: z.string().trim().max(120).optional(),
  message: z.string().trim().max(5000).optional(),
});
