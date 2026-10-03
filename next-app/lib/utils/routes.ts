export const publicRoutes = ["/", "/about", "/services", "/contact"] as const;
export const authRoutes = ["/login"] as const;
export const dashboardPrefix = "/dashboard";

export function isDashboardRoute(pathname: string) {
  return pathname === dashboardPrefix || pathname.startsWith(`${dashboardPrefix}/`);
}
