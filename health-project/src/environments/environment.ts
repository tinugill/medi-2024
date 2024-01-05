// This file can be replaced during build by using the `fileReplacements` array.
// `ng build` replaces `environment.ts` with `environment.prod.ts`.
// The list of file replacements can be found in `angular.json`.

export const environment = {
  production: false,
  // base_url: 'http://127.0.0.1:8000/api/',
  // auth_url: 'http://127.0.0.1:8000/api/customer/',
  // site_url: 'http://127.0.0.1:8000/',
  // my_url: 'http://127.0.0.1:8000/',
  base_url: 'https://admin.topmedz.com/api/',
  auth_url: 'https://admin.topmedz.com/api/customer/',
  site_url: 'https://admin.topmedz.com/',
  my_url: 'https://topmedz.com/',
  zoom_login: 'https://zoom.us/oauth/authorize?client_id=Oxy8lGcZRVuFZOPMqRqXxg&response_type=code&redirect_uri=http%3A%2F%2Fadmin.topmedz.com%2Fapi%2Fzoom-verify'

};

/*
 * For easier debugging in development mode, you can import the following file
 * to ignore zone related error stack frames such as `zone.run`, `zoneDelegate.invokeTask`.
 *
 * This import should be commented out in production mode because it will have a negative impact
 * on performance if an error is thrown.
 */
// import 'zone.js/plugins/zone-error';  // Included with Angular CLI.
