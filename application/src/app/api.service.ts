import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpErrorResponse, HttpParams } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/map';

@Injectable ()
export class ApiService {

  /**
   * Variables of the request.
   *
   * @var mixed
   */
  private baseUrl: string = 'http://localhost:8000/';
  private url: string;
  private results: any;

  constructor (private http: HttpClient) { }
  
  /**
   * Update the parameters of the Http request.
   *
   * @param  array  query
   * @return HttpParams
   */
  private updateParams (query: string[]): HttpParams {
    let httpParams = new HttpParams ();
    for (let key in query) {
      httpParams = httpParams.set (key, query [key]);
    }
    return httpParams;
  }

  /**
   * Fetch the data with Http request.
   *
   * @param  string  url
   * @param  array   query
   * @return Observable
   */
  fetchData (appendUrl: string, query: string[]): Observable<any> {
    return this.http.get (this.baseUrl + appendUrl, {
      params: this.updateParams (query)
    }).map (
      (data: Response) => data,
      (err: HttpErrorResponse) => err
    )
  }
}
