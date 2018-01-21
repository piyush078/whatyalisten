import { Injectable } from '@angular/core';

@Injectable ()
export class ErrorService {

  constructor () {}

  /**
   * Show the Http error.
   *
   * @param  HttpErrorResponse
   * @return void
   */
  formatError (error: Object): void {
    console.log (error.error);
  }
}
