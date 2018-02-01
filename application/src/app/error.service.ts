import { Injectable } from '@angular/core';

@Injectable ()
export class ErrorService {

  /**
   * Error variable.
   *
   * @var string
   */
  public text: string;

  /**
   * Set the value of the error variable.
   *
   * @param  HttpErrorResponse
   * @return void
   */
  formatError (error: Object): void {
    if (error.hasOwnProperty ('error') && error ['error'].hasOwnProperty ('responseText')) {
      this.text = error ['error']['responseText'];
    } else {
      this.text = 'Something is wrong. Please try again.';
    }
  }
}
